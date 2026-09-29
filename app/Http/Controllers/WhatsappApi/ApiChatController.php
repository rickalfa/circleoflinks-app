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
     * Obtiene la conversación activa y sus mensajes a partir del ID del Lead
     */
    public function getConversation($leadId)
    {
        $lead = Lead::with('user.conversations.messages')->findOrFail($leadId);
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

        // Marcar como leído
        if ($lead->has_unread_messages) {
            $lead->update(['has_unread_messages' => false]);
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
            'conversation_id' => 'required|integer|exists:conversations,id',
            'action' => 'sometimes|in:human_active,bot_active'
        ]);

        $conversation = Conversation::find($request->conversation_id);
        
        $newStatus = $request->action ?? 'human_active';
        $assignedUser = $newStatus === 'human_active' ? (auth()->id() ?? 1) : null;

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
            'conversation_id' => 'required|integer|exists:conversations,id',
            'phone' => 'required|string',
            'message' => 'required|string'
        ]);

        $conversation = Conversation::find($request->conversation_id);

        // 1. Enviar el mensaje a Meta (API Cloud)
        $sendController = new WspSendMessageController();
        $response = $sendController->sendMessageWsp($request->message, $request->phone);

        // 2. Guardar en Base de Datos
        $messageRecord = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id() ?? 1, // El ID del admin (o fallback)
            'sender_type' => 'admin',
            'content' => $request->message,
            'sent_at' => now()
        ]);

        // Actualizar el Lead (último mensaje)
        Lead::where('user_id', $conversation->user_id)->update(['last_message_time' => now()]);

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
            'lead_id' => 'required|integer|exists:leads,id',
        ]);

        $lead = Lead::findOrFail($request->lead_id);

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
        $leads = Lead::select('id', 'has_unread_messages')->get();
        return response()->json([
            'success' => true,
            'data' => $leads
        ]);
    }
}
