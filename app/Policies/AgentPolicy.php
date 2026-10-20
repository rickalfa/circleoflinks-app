<?php

namespace App\Policies;

use App\Models\WhatsappApi\Agent;
use App\Models\User;
use App\Enums\PermissionEnum;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any agents.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionEnum::WHATSAPP_VIEW->value) 
            || $user->can(PermissionEnum::WHATSAPP_MANAGE->value);
    }

    /**
     * Determine whether the user can view the specific agent.
     */
    public function view(User $user, Agent $agent): bool
    {
        if (!$this->viewAny($user)) {
            return false;
        }

        return $this->ownsAgentProject($user, $agent);
    }

    /**
     * Determine whether the user can create agents.
     * Combina permiso de rol (Spatie) + límites de plan (HasPlanLimits).
     */
    public function create(User $user): bool
    {
        if (!$user->can(PermissionEnum::WHATSAPP_MANAGE->value)) {
            return false;
        }

        $project = $user->currentProject();
        if (!$project) {
            return false;
        }

        $currentBotCount = Agent::where('project_id', $project->id)->count();

        return $user->canCreateMoreBots($currentBotCount);
    }

    /**
     * Determine whether the user can configure and enable AI (LLM) on agents.
     * Exclusivo de cuentas en plan Premium.
     */
    public function useAi(User $user): bool
    {
        if (!$user->can(PermissionEnum::WHATSAPP_MANAGE->value)) {
            return false;
        }

        return $user->canUseAiBots();
    }

    /**
     * Determine whether the user can update the agent.
     */
    public function update(User $user, Agent $agent): bool
    {
        if (!$user->can(PermissionEnum::WHATSAPP_MANAGE->value)) {
            return false;
        }

        return $this->ownsAgentProject($user, $agent);
    }

    /**
     * Determine whether the user can delete the agent.
     */
    public function delete(User $user, Agent $agent): bool
    {
        if (!$user->can(PermissionEnum::WHATSAPP_MANAGE->value)) {
            return false;
        }

        return $this->ownsAgentProject($user, $agent);
    }

    /**
     * Verifica si el agente pertenece a algún proyecto de las empresas del usuario.
     */
    protected function ownsAgentProject(User $user, Agent $agent): bool
    {
        if (empty($agent->project_id)) {
            return true;
        }

        $userProjectIds = $user->projects()->pluck('projects.id')->toArray();

        return in_array($agent->project_id, $userProjectIds);
    }
}
