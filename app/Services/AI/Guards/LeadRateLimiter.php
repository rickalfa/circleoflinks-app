<?php

namespace App\Services\AI\Guards;

use Illuminate\Support\Facades\Cache;

class LeadRateLimiter
{
    protected int $dailyLimit;

    public function __construct()
    {
        $this->dailyLimit = (int) config('ai.daily_limit_per_lead', 25);
    }

    /**
     * Verifica si el lead aún puede recibir respuestas automáticas de IA hoy.
     */
    public function isAllowed(int $projectId, int $leadId): bool
    {
        $currentHits = $this->getHits($projectId, $leadId);
        return $currentHits < $this->dailyLimit;
    }

    /**
     * Incrementa el contador de respuestas de IA para el lead actual.
     */
    public function hit(int $projectId, int $leadId): int
    {
        $key = $this->getCacheKey($projectId, $leadId);
        $hits = (int) Cache::get($key, 0) + 1;
        Cache::put($key, $hits, now()->endOfDay());

        return $hits;
    }

    /**
     * Retorna la cantidad actual de respuestas emitidas hoy para este lead.
     */
    public function getHits(int $projectId, int $leadId): int
    {
        return (int) Cache::get($this->getCacheKey($projectId, $leadId), 0);
    }

    protected function getCacheKey(int $projectId, int $leadId): string
    {
        return "ai_limit_{$projectId}_{$leadId}_" . now()->format('Y-m-d');
    }
}
