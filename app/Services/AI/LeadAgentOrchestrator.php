<?php

namespace App\Services\AI;

use App\Models\Project;
use App\Models\WhatsappApi\Agent;
use App\Models\WhatsappApi\Conversation;
use App\Models\WhatsappApi\Lead;
use App\Models\WhatsappApi\Message;
use App\Services\AI\DTOs\LlmResponse;
use App\Services\AI\Guards\BudgetGuard;
use App\Services\AI\Guards\LeadRateLimiter;
use App\Services\AI\Guards\MessageSanitizer;
use App\Services\AI\Prompts\AgentPromptBuilder;
use Illuminate\Support\Facades\Log;
use Exception;

class LeadAgentOrchestrator
{
    public function __construct(
        protected MllServiceManager $mllManager,
        protected MessageSanitizer $sanitizer,
        protected LeadRateLimiter $rateLimiter,
        protected BudgetGuard $budgetGuard,
        protected AgentPromptBuilder $promptBuilder
    ) {}

    /**
     * Ejecuta el pipeline completo de los 6 pasos y retorna el LlmResponse final.
     */
    public function process(Conversation $conversation, string $rawMessage, Project $project): ?LlmResponse
    {
        $lead = Lead::where('user_id', $conversation->user_id)->first();
        $leadId = $lead ? $lead->id : 0;

        // -------------------------------------------------------------
        // PASO 2: Sanitización y Validación del Mensaje
        // -------------------------------------------------------------
        $cleanedMessage = $this->sanitizer->sanitize($rawMessage);
        if (empty($cleanedMessage)) {
            Log::info("LeadAgentOrchestrator: Mensaje vacío tras sanitización. Omitiendo llamada.");
            return null;
        }

        if ($this->sanitizer->containsPromptInjection($cleanedMessage)) {
            Log::warning("LeadAgentOrchestrator: Intento de Prompt Injection detectado para el lead {$leadId}.");
            return new LlmResponse(
                text: "Entiendo tu consulta, pero estoy aquí para ayudarte exclusivamente con información sobre nuestros servicios. ¿En qué te puedo orientar?",
                promptTokens: 0,
                completionTokens: 0,
                totalTokens: 0,
                costUsd: 0.0,
                provider: 'system',
                model: 'shield',
                handover: false
            );
        }

        // -------------------------------------------------------------
        // PASO 3: Validación de Límite Diario por Lead (Rate Limiting)
        // -------------------------------------------------------------
        if ($leadId > 0 && !$this->rateLimiter->isAllowed($project->id, $leadId)) {
            Log::info("LeadAgentOrchestrator: Límite diario alcanzado para lead {$leadId}. Derivando a humano.");
            return new LlmResponse(
                text: "Has alcanzado el límite de consultas automáticas por hoy. En breve uno de nuestros asesores continuará tu atención personalmente.",
                promptTokens: 0,
                completionTokens: 0,
                totalTokens: 0,
                costUsd: 0.0,
                provider: 'system',
                model: 'rate_limiter',
                handover: true // Activa derivación a humano
            );
        }

        // -------------------------------------------------------------
        // PASO 4: Validación de Presupuesto Mensual del Proyecto y Plan
        // -------------------------------------------------------------
        if (!$project->allowsAiBots()) {
            Log::warning("LeadAgentOrchestrator: Proyecto ID {$project->id} pertenece a un plan Free (sin IA). Cancelando procesamiento LLM.");
            return null;
        }

        if (!$this->budgetGuard->hasBudget($project)) {
            Log::warning("LeadAgentOrchestrator: Presupuesto mensual agotado para proyecto {$project->id}. Derivando a humano.");
            return new LlmResponse(
                text: "Nuestros canales de asistencia automática están momentáneamente saturados. Un asesor humano te responderá en breve.",
                promptTokens: 0,
                completionTokens: 0,
                totalTokens: 0,
                costUsd: 0.0,
                provider: 'system',
                model: 'budget_guard',
                handover: true // Silencia IA y llama a humano
            );
        }

        // -------------------------------------------------------------
        // PASO 5: Obtener y Validar el Agente Configurado para el Proyecto
        // -------------------------------------------------------------
        // Buscar primer agente del proyecto con IA activada
        $agent = Agent::where('project_id', $project->id)
            ->where('status', 'active')
            ->where('ai_enabled', true)
            ->first();

        // Fallback 1: Buscar por el agent_id asignado en la conversación
        if (!$agent && !empty($conversation->agent_id)) {
            $agent = Agent::where('id', $conversation->agent_id)
                ->where('ai_enabled', true)
                ->first();
        }

        // Fallback 2: Buscar cualquier bot activo que tenga ai_enabled = true
        if (!$agent) {
            $agent = Agent::where('status', 'active')
                ->where('ai_enabled', true)
                ->first();
        }

        // Si no hay bot con IA activa en el sistema, no responder
        if (!$agent) {
            Log::warning("LeadAgentOrchestrator: No se encontró ningún agente activo con 'ai_enabled' = true.");
            return null;
        }

        // -------------------------------------------------------------
        // PASO 6: Detección de Bienvenida e Historial de Conversación
        // -------------------------------------------------------------
        $historyLimit = (int) config('ai.history_message_limit', 8);
        $recentMessages = Message::where('conversation_id', $conversation->id)
            ->orderBy('id', 'desc')
            ->take($historyLimit)
            ->get()
            ->reverse()
            ->values()
            ->all();

        // Es primer contacto si solo existe el mensaje que acaba de llegar (o ninguno)
        $isFirstContact = count($recentMessages) <= 1;

        $promptMessages = $this->promptBuilder->build(
            agent: $agent,
            lead: $lead,
            recentMessages: $recentMessages,
            currentMessage: $cleanedMessage,
            isFirstContact: $isFirstContact
        );

        // -------------------------------------------------------------
        // LLAMADA AL MOTOR LLM (Gemini / OpenAI resuelto por Factory)
        // -------------------------------------------------------------
        try {
            $llmService = $this->mllManager->driver($agent->ai_provider, $agent->ai_model);
            
            $response = $llmService->chat($promptMessages, [
                'temperature' => (float) ($agent->temperature ?? 0.70),
                'max_tokens'  => 400,
            ]);

            // Incrementar contador diario del lead
            if ($leadId > 0) {
                $this->rateLimiter->hit($project->id, $leadId);
            }

            return $response;

        } catch (Exception $e) {
            Log::error("LeadAgentOrchestrator Excepción: " . $e->getMessage());
            return null;
        }
    }
}
