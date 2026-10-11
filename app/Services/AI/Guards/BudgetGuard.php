<?php

namespace App\Services\AI\Guards;

use App\Models\Project;
use App\Models\WhatsappApi\AiUsageLog;
use App\Services\AI\DTOs\LlmResponse;

class BudgetGuard
{
    /**
     * Verifica si el proyecto tiene presupuesto suficiente en el mes.
     */
    public function hasBudget(Project $project): bool
    {
        return $project->hasAvailableAiBudget();
    }

    /**
     * Registra el gasto exacto en la tabla normalizada ai_usage_logs.
     */
    public function recordUsage(int $messageId, LlmResponse $response): AiUsageLog
    {
        return AiUsageLog::create([
            'message_id'        => $messageId,
            'provider'          => $response->provider,
            'model'             => $response->model,
            'prompt_tokens'     => $response->promptTokens,
            'completion_tokens' => $response->completionTokens,
            'cost_usd'          => $response->costUsd,
        ]);
    }
}
