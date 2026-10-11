<?php

namespace App\Services\AI\Prompts;

use App\Models\WhatsappApi\Agent;
use App\Models\WhatsappApi\Lead;
use App\Services\AI\DTOs\LlmMessage;

class AgentPromptBuilder
{
    /**
     * Construye el arreglo completo de mensajes para el LLM (System Prompt + Historial + Mensaje Actual).
     *
     * @param Agent $agent
     * @param Lead|null $lead
     * @param array $recentMessages Lista de modelos Message recientes
     * @param string $currentMessage
     * @param bool $isFirstContact
     * @return array<LlmMessage>
     */
    public function build(
        Agent $agent,
        ?Lead $lead,
        array $recentMessages,
        string $currentMessage,
        bool $isFirstContact = false
    ): array {
        $systemInstructions = $this->buildSystemPrompt($agent, $lead, $isFirstContact);

        $messages = [];
        $messages[] = LlmMessage::system($systemInstructions);

        // Añadir el historial reciente en orden cronológico (ventana deslizante)
        foreach ($recentMessages as $msg) {
            $role = ($msg->sender_type === 'agent' || $msg->sender_type === 'admin') ? 'assistant' : 'user';
            $messages[] = new LlmMessage($role, (string) $msg->content);
        }

        // Añadir el mensaje actual del lead
        $messages[] = LlmMessage::user($currentMessage);

        return $messages;
    }

    /**
     * Ensambla el System Prompt con personalidad, historia, base de conocimiento y formato de salida.
     */
    protected function buildSystemPrompt(Agent $agent, ?Lead $lead, bool $isFirstContact): string
    {
        $name        = $agent->persona_name ?: ($agent->name ?: 'Asistente Virtual');
        $role        = $agent->role ?: 'Representante de atención y ventas';
        $tone        = $agent->tone ?: 'cercano, respetuoso y profesional';
        $personality = $agent->personality ?: 'Empática, proactiva y orientada a resolver consultas.';
        $backstory   = $agent->backstory ?: 'Cuentas con amplia experiencia asistiendo a los clientes de este negocio.';
        $knowledge   = $agent->knowledge_base ?: 'Brindas información general sobre los productos y servicios de la empresa.';
        $styleRules  = $agent->style_rules ?: 'Respuestas concisas de máximo 2 a 3 líneas. Usa 1 o 2 emojis naturales. No uses listas interminables. Termina frecuentemente con una pregunta.';
        $boundaries  = $agent->boundaries ?: 'Si te preguntan si eres un robot o IA, admite amablemente que eres un asistente virtual. No inventes precios ni condiciones no estipuladas. Si el cliente solicita hablar con una persona real o tiene un reclamo grave, indícale que derivarás el caso a un asesor.';

        $leadName = $lead ? ($lead->name ?: 'Cliente') : 'Cliente';

        $prompt = "### IDENTIDAD Y ROL\n";
        $prompt .= "Eres {$name}, cumples el rol de {$role}.\n";
        $prompt .= "Tu tono es: {$tone}.\n";
        $prompt .= "Rasgos de personalidad: {$personality}\n\n";

        $prompt .= "### TU HISTORIA Y TRASFONDO (BACKSTORY)\n";
        $prompt .= "{$backstory}\n";
        $prompt .= "Habla desde este trasfondo si te preguntan sobre ti con coherencia y naturalidad.\n\n";

        $prompt .= "### INFORMACIÓN DEL CLIENTE ACTUAL\n";
        $prompt .= "Estás conversando con: {$leadName} a través de WhatsApp.\n\n";

        if ($isFirstContact) {
            $prompt .= "### INSTRUCCIÓN DE BIENVENIDA (PRIMER CONTACTO)\n";
            $prompt .= "Este es el primer contacto de este cliente. Salúdalo cálidamente por su nombre si está disponible, preséntate brevemente con tu nombre y menciona en qué le puedes orientar hoy.\n\n";
        }

        $prompt .= "### BASE DE CONOCIMIENTO DEL NEGOCIO\n";
        $prompt .= "Usa EXCLUSIVAMENTE esta información para responder sobre servicios, precios y horarios:\n";
        $prompt .= "{$knowledge}\n\n";

        $prompt .= "### REGLAS DE ESTILO PARA WHATSAPP\n";
        $prompt .= "{$styleRules}\n\n";

        $prompt .= "### LÍMITES Y POLÍTICAS OBLIGATORIAS\n";
        $prompt .= "{$boundaries}\n\n";

        $prompt .= "### FORMATO DE RESPUESTA OBLIGATORIO (JSON)\n";
        $prompt .= "Debes responder SIEMPRE con un objeto JSON válido con la siguiente estructura:\n";
        $prompt .= "{\n";
        $prompt .= '  "reply": "Texto de tu respuesta en WhatsApp listo para enviar",'. "\n";
        $prompt .= '  "handover": false,'. "\n";
        $prompt .= '  "intent": "general_inquiry"'. "\n";
        $prompt .= "}\n";
        $prompt .= "- 'handover' debe ser TRUE ÚNICAMENTE si el cliente exige hablar con un humano, tiene una queja severa o solicita cerrar un contrato con un asesor.\n";
        $prompt .= "- No incluyas bloques de código markdown como ```json antes ni después del objeto. Devuelve solo el JSON puro.\n";

        return $prompt;
    }
}
