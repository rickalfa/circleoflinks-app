<?php

namespace App\Jobs\WhatsappApi;

use App\Http\Controllers\WhatsappApi\WspSendMessageController;
use App\Models\Project;
use App\Models\userAppContact;
use App\Models\WhatsappApi\Conversation;
use App\Models\WhatsappApi\Message;
use App\Services\AI\Guards\BudgetGuard;
use App\Services\AI\LeadAgentOrchestrator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessAiReplyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;
    public int $timeout = 30;

    public function __construct(
        public int $conversationId,
        public string $userMessage,
        public int $projectId
    ) {}

    /**
     * Ejecuta el trabajo asíncrono para generar y despachar la respuesta con IA.
     */
    public function handle(
        LeadAgentOrchestrator $orchestrator,
        BudgetGuard $budgetGuard,
        WspSendMessageController $sender
    ): void {
        Log::info("ProcessAiReplyJob: Iniciando procesamiento asíncrono para conversación ID {$this->conversationId}");

        $conversation = Conversation::find($this->conversationId);
        $project = Project::find($this->projectId);

        if (!$conversation || !$project) {
            Log::warning("ProcessAiReplyJob: Conversación o proyecto no encontrado. Abortando.");
            return;
        }

        // Si mientras el Job estaba en cola un humano tomó el control, no responder con IA
        if ($conversation->status !== 'bot_active') {
            Log::info("ProcessAiReplyJob: Conversación no está en 'bot_active' (estado actual: {$conversation->status}). IA silenciada.");
            return;
        }

        // Obtener teléfono del usuario para enviar la respuesta
        $userPhone = null;
        $contact = userAppContact::where('user_id', $conversation->user_id)->first();
        if ($contact && !empty($contact->phone_number)) {
            $userPhone = $contact->phone_number;
        } else {
            $lead = \App\Models\WhatsappApi\Lead::where('user_id', $conversation->user_id)->first();
            $userPhone = $lead ? $lead->phone_number : null;
        }

        if (!$userPhone) {
            Log::warning("ProcessAiReplyJob: No se encontró número de teléfono para el usuario ID {$conversation->user_id}.");
            return;
        }

        // Ejecutar los 6 pasos a través del orquestador
        $response = $orchestrator->process($conversation, $this->userMessage, $project);

        if (!$response || empty(trim($response->text))) {
            Log::info("ProcessAiReplyJob: No se generó respuesta de IA.");
            return;
        }

        // 1. Enviar el mensaje por WhatsApp Graph API
        Log::info("ProcessAiReplyJob: Enviando respuesta de IA a {$userPhone}...");
        $sender->sendMessageWsp($response->text, $userPhone);

        // 2. Guardar el mensaje del agente en la base de datos
        $agentId = $conversation->agent_id ?: 1;
        $savedMessage = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $agentId,
            'sender_type'     => 'agent',
            'content'         => $response->text,
            'sent_at'         => now(),
        ]);

        // 3. Registrar auditoría de tokens normalizada (Opción B: 1-a-1 con message_id)
        if ($response->totalTokens > 0) {
            $budgetGuard->recordUsage($savedMessage->id, $response);
            Log::info("ProcessAiReplyJob: Tokens registrados en ai_usage_logs para message_id {$savedMessage->id} (Costo: \${$response->costUsd} USD)");
        }

        // 4. Aplicar Handover si la IA lo solicitó
        if ($response->isHandoverRequested()) {
            $conversation->update(['status' => 'human_active']);
            Log::info("ProcessAiReplyJob: Handover activado. Conversación {$conversation->id} cambiada a 'human_active'.");
        }
    }
}
