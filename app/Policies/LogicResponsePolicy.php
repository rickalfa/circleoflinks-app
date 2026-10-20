<?php

namespace App\Policies;

use App\Models\WhatsappApi\LogicResponse;
use App\Models\WhatsappApi\Agent;
use App\Models\User;
use App\Enums\PermissionEnum;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogicResponsePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(PermissionEnum::WHATSAPP_VIEW->value) 
            || $user->can(PermissionEnum::WHATSAPP_MANAGE->value);
    }

    public function view(User $user, LogicResponse $logicResponse): bool
    {
        if (!$this->viewAny($user)) {
            return false;
        }

        $agent = $logicResponse->agent;
        return $agent ? $this->ownsAgentProject($user, $agent) : false;
    }

    public function create(User $user, ?Agent $agent = null): bool
    {
        if (!$user->can(PermissionEnum::WHATSAPP_MANAGE->value)) {
            return false;
        }

        if ($agent && !$this->ownsAgentProject($user, $agent)) {
            return false;
        }

        return true;
    }

    public function update(User $user, LogicResponse $logicResponse): bool
    {
        if (!$user->can(PermissionEnum::WHATSAPP_MANAGE->value)) {
            return false;
        }

        $agent = $logicResponse->agent;
        return $agent ? $this->ownsAgentProject($user, $agent) : false;
    }

    public function delete(User $user, LogicResponse $logicResponse): bool
    {
        if (!$user->can(PermissionEnum::WHATSAPP_MANAGE->value)) {
            return false;
        }

        $agent = $logicResponse->agent;
        return $agent ? $this->ownsAgentProject($user, $agent) : false;
    }

    protected function ownsAgentProject(User $user, Agent $agent): bool
    {
        if (empty($agent->project_id)) {
            return true;
        }

        $userProjectIds = $user->projects()->pluck('projects.id')->toArray();

        return in_array($agent->project_id, $userProjectIds);
    }
}
