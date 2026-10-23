<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatsappApi\Lead;
use App\Models\WhatsappApi\Conversation;
use App\Models\WhatsappApi\Message;
use App\Services\WhatsappApi\WhatsAppProfileService;

class ApiChatController extends Controller
{
    /**
     * Límite de caracteres de un mensaje de texto en WhatsApp Cloud API.
     */
    private const WSP_MAX_MESSAGE_LENGTH = 4096;

    /**
     * Obtiene la conversación activa y sus mensajes a partir del ID del Lead
     */
    public function getConversation($leadId)
    {
        // SEGURIDAD: solo leads de los proyectos del usuario autenticado (404 si no le pertenece)
        $lead = $this->findOwnedLeadOrFail((int) $leadId);
        $lead->load('user');
        $userApp = $lead->user;

        if (!$userApp) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Obtener la conversación activa del usuario (la última)
        $conversation = $userApp->conversations()->orderBy('id', 'desc')->first();

        if (!$conversation) {
            return response()->json(['data' => null]); // Aún no hay mensajes
        }

        // Cargar los mensajes de esa conversación
        $conversation->load('messages');

        // Marcar como leído y reiniciar contador
        if ($lead->has_unread_messages || $lead->unread_messages_count > 0) {
            $lead->update([
                'has_unread_messages' => false,
                'unread_messages_count' => 0
            ]);
        }

        return response()->json([
            'conversation' => $conversation,
            'lead' => $lead
        ]);
    }

    /**
     * El operador asume el control del chat, silenciando al bot
     */
    public function takeControl(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            'action' => 'sometimes|in:human_active,bot_active'
        ]);

        // SEGURIDAD: la conversación debe pertenecer a un lead del usuario autenticado
        [$conversation] = $this->findOwnedConversationOrFail((int) $request->conversation_id);

        $newStatus = $request->action ?? 'human_active';
        // SEGURIDAD: se asigna siempre al usuario autenticado (sin fallback a otro ID)
        $assignedUser = $newStatus === 'human_active' ? auth()->id() : null;

        $conversation->update([
            'status' => $newStatus,
            'assigned_user_id' => $assignedUser
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado del chat actualizado.',
            'status' => $conversation->status
        ]);
    }

    /**
     * El operador envía un mensaje al usuario
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            // 'phone' se acepta por compatibilidad con el frontend, pero se IGNORA:
            // el destino se obtiene siempre del Lead dueño de la conversación.
            'phone' => 'sometimes|nullable|string|max:20',
            'message' => 'required|string|max:' . self::WSP_MAX_MESSAGE_LENGTH,
        ]);

        // SEGURIDAD: la conversación debe pertenecer a un lead del usuario autenticado
        [$conversation, $lead] = $this->findOwnedConversationOrFail((int) $request->conversation_id);

        if (!$lead->phone_number) {
            return response()->json(['success' => false, 'message' => 'El lead no tiene número de teléfono.'], 422);
        }

        // 1. Enviar el mensaje a Meta (API Cloud) — destino tomado de la BD, nunca del cliente
        $sendController = new WspSendMessageController();
        $response = $sendController->sendMessageWsp($request->message, $lead->phone_number);

        // 2. Guardar en Base de Datos
        $messageRecord = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(), // El ID del operador autenticado
            'sender_type' => 'admin',
            'content' => $request->message,
            'sent_at' => now()
        ]);

        // Actualizar el Lead (último mensaje)
        $lead->update(['last_message_time' => now()]);

        return response()->json([
            'success' => true,
            'message' => $messageRecord,
            'meta_response' => $response
        ]);
    }

    /**
     * Refresca el avatar de un Lead consultando el perfil en WhatsApp Cloud API.
     * Útil para actualizar la foto de perfil de contactos existentes.
     */
    public function refreshLeadAvatar(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|integer',
        ]);

        // SEGURIDAD: solo leads de los proyectos del usuario autenticado
        $lead = $this->findOwnedLeadOrFail((int) $request->lead_id);

        if (!$lead->phone_number) {
            return response()->json(['success' => false, 'message' => 'El lead no tiene número de teléfono.'], 422);
        }

        $profileService = new WhatsAppProfileService();
        $freshAvatarUrl = $profileService->refreshProfilePictureUrl($lead->phone_number);

        // Si la API no devuelve imagen, generar un avatar dinámico basado en el nombre
        if (!$freshAvatarUrl) {
            $encodedName = urlencode($lead->name ?? 'Lead');
            $freshAvatarUrl = "https://ui-avatars.com/api/?name={$encodedName}&background=25D366&color=fff&size=128";
        }

        $lead->update(['avatar_url' => $freshAvatarUrl]);

        return response()->json([
            'success'    => true,
            'avatar_url' => $freshAvatarUrl,
            'lead'       => $lead,
        ]);
    }

    /**
     * Devuelve el estado de mensajes no leídos para cada lead.
     */
    public function getUnreadStatus()
    {
        // SEGURIDAD: antes devolvía los leads de TODAS las cuentas; ahora solo los propios
        $leads = Lead::ownedBy(auth()->user())
            ->select('id', 'has_unread_messages', 'unread_messages_count')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $leads
        ]);
    }

    /**
     * Devuelve la tabla paginada de Leads (5 o 10 por página) con datos de Contacto
     * en plataforma y estado de atención (solicita humano / atendido por humano / bot).
     */
    public function getLeadsTable(Request $request)
    {
        $user = $request->user();
        $perPage = in_array((int) $request->query('per_page', 10), [5, 10], true)
            ? (int) $request->query('per_page', 10)
            : 10;

        $latestConvStatusSql = "(SELECT c.status FROM conversations c WHERE c.user_id = leads.user_id ORDER BY c.id DESC LIMIT 1)";
        $latestConvAssignedSql = "(SELECT c.assigned_user_id FROM conversations c WHERE c.user_id = leads.user_id ORDER BY c.id DESC LIMIT 1)";

        $query = Lead::ownedBy($user)
            ->with([
                'user.StatusUserApp',
                'user.contact',
                'latestConversation.assignedUser:id,name',
                'latestConversation.latestMessage',
            ])
            ->orderByRaw("CASE
                WHEN {$latestConvStatusSql} = 'human_active' AND {$latestConvAssignedSql} IS NULL THEN 0
                WHEN {$latestConvStatusSql} = 'human_active' AND {$latestConvAssignedSql} IS NOT NULL THEN 1
                ELSE 2
            END ASC")
            ->orderByDesc('last_message_time')
            ->orderByDesc('id');

        $paginator = $query->paginate($perPage);

        // Total de leads esperando humano en todos los proyectos del usuario
        $waitingHumanCount = Lead::ownedBy($user)
            ->whereRaw("{$latestConvStatusSql} = 'human_active' AND {$latestConvAssignedSql} IS NULL")
            ->count();

        $currentUserId = (int) $user->id;

        $rows = collect($paginator->items())->map(function (Lead $lead) use ($currentUserId) {
            $userApp = $lead->user;
            $statusName = $userApp?->StatusUserApp?->name;
            $contactModel = $userApp?->contact;
            $isContact = $statusName === 'contact';

            $conv = $lead->latestConversation;
            $rawStatus = $conv?->status;
            $assignedUser = $conv?->assignedUser;

            if (!$conv) {
                $attentionStatus = 'NO_CONVERSATION';
            } elseif ($rawStatus === 'human_active' && !$assignedUser) {
                $attentionStatus = 'WAITING_HUMAN';
            } elseif ($rawStatus === 'human_active' && $assignedUser) {
                $attentionStatus = 'HUMAN_ACTIVE';
            } elseif ($rawStatus === 'closed') {
                $attentionStatus = 'CLOSED';
            } else {
                $attentionStatus = 'BOT_ACTIVE';
            }

            $assignedPayload = null;
            if ($assignedUser) {
                $isMe = ((int) $assignedUser->id === $currentUserId);
                $assignedPayload = [
                    'id' => $assignedUser->id,
                    'name' => $isMe ? ($assignedUser->name . ' (tú)') : $assignedUser->name,
                    'is_me' => $isMe,
                ];
            }

            return [
                'id' => $lead->id,
                'name' => $lead->name ?? 'Lead',
                'phone_number' => $lead->phone_number ?? '',
                'avatar_url' => $lead->avatar_url,
                'last_message_time' => $lead->last_message_time,
                'unread_messages_count' => (int) ($lead->unread_messages_count ?? 0),
                'has_unread_messages' => (bool) $lead->has_unread_messages,
                'contact' => [
                    'is_contact' => $isContact,
                    'user_app_id' => $userApp?->id,
                    'name' => $userApp?->name ?? $lead->name,
                    'email' => $userApp?->email,
                    'address' => $userApp?->address,
                    'phone_number' => $contactModel?->phone_number ?? $lead->phone_number,
                    'status_name' => $statusName ?? 'sin-estado',
                ],
                'attention' => [
                    'conversation_id' => $conv?->id,
                    'status' => $attentionStatus,
                    'raw_status' => $rawStatus,
                    'assigned_user' => $assignedPayload,
                    'since' => $conv?->updated_at?->toIso8601String(),
                    'last_message_preview' => $conv?->latestMessage?->content,
                ],
            ];
        })->values();

        return response()->json([
            'data' => $rows,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'waiting_human_count' => $waitingHumanCount,
            ],
        ]);
    }

    /**
     * Convierte un Lead en Contacto dentro de la plataforma (user_app_status = 'contact').
     */
    public function convertToContact(Request $request, $leadId)
    {
        $lead = $this->findOwnedLeadOrFail((int) $leadId);
        $userApp = $lead->user;

        if (!$userApp) {
            return response()->json(['success' => false, 'message' => 'Usuario asociado al Lead no encontrado.'], 404);
        }

        $contactStatus = \App\Models\UserAppStatus::firstOrCreate(
            ['name' => 'contact'],
            ['description' => 'Contacto registrado en la plataforma']
        );

        $userApp->user_app_status_id = $contactStatus->id;
        $userApp->save();

        if ($lead->phone_number) {
            \App\Models\userAppContact::firstOrCreate(
                ['user_id' => $userApp->id],
                ['phone_number' => $lead->phone_number, 'status' => 'active']
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Lead convertido a contacto correctamente.',
        ]);
    }

    /* ------------------------------------------------------------------
     |  Helpers de autorización
     | ------------------------------------------------------------------
     |  Devuelven 404 (no 403) cuando el recurso no pertenece al usuario,
     |  para no revelar la existencia de recursos de otras cuentas.
     */

    /**
     * Busca un Lead que pertenezca a los proyectos del usuario autenticado.
     */
    private function findOwnedLeadOrFail(int $leadId): Lead
    {
        return Lead::ownedBy(auth()->user())->findOrFail($leadId);
    }

    /**
     * Busca una Conversación cuyo Lead pertenezca al usuario autenticado.
     *
     * @return array{0: Conversation, 1: Lead}
     */
    private function findOwnedConversationOrFail(int $conversationId): array
    {
        $conversation = Conversation::findOrFail($conversationId);

        $lead = Lead::ownedBy(auth()->user())
            ->where('user_id', $conversation->user_id)
            ->first();

        abort_if(!$lead, 404);

        return [$conversation, $lead];
    }
}
