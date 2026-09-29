<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Contamos cuántos proyectos tiene el usuario sumando los de todas sus empresas
        $currentProjectCount = 0;
        foreach ($user->companies as $company) {
            $currentProjectCount += $company->projects()->count();
        }

        return $user->canCreateMoreProjects($currentProjectCount);
    }
}
