<?php

namespace App\Traits;

trait HasPlanLimits
{
    /**
     * Get the user's current plan configuration.
     *
     * @return array
     */
    public function getPlanConfig(): array
    {
        $plan = $this->plan ?? 'free';
        return config("plans.{$plan}", config('plans.free'));
    }

    /**
     * Check if the user has reached the maximum number of bots allowed.
     *
     * @param int $currentBotCount
     * @return bool
     */
    public function canCreateMoreBots(int $currentBotCount): bool
    {
        $limit = $this->getPlanConfig()['max_bots'];
        
        if ($limit === -1) {
            return true;
        }

        return $currentBotCount < $limit;
    }

    /**
     * Check if the user has reached the maximum number of projects allowed.
     *
     * @param int $currentProjectCount
     * @return bool
     */
    public function canCreateMoreProjects(int $currentProjectCount): bool
    {
        $limit = $this->getPlanConfig()['max_projects'];
        
        if ($limit === -1) {
            return true;
        }

        return $currentProjectCount < $limit;
    }

    /**
     * Check if the user is allowed to send proactive messages (templates).
     *
     * @return bool
     */
    public function canSendProactiveMessages(): bool
    {
        return $this->getPlanConfig()['proactive_messaging'];
    }
}
