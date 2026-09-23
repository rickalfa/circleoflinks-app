<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatsappApi\Lead;
use App\Models\WhatsappApi\Conversation;
use App\Models\WhatsappApi\Message;

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
}
