<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function store(User $user): Response
    {
        return $user->role === 1
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Project $project): Response
    {
        $userBelongsToProject = $project
            ->users()
            ->wherePivot('user_id', $user->id)
            ->exists();

        return $userBelongsToProject
            ? $this->allow()
            : $this->deny();
    }

    public function destroy(User $user, Project $project): Response
    {
        $userBelongsToProject = $project
            ->users()
            ->wherePivot('user_id', $user->id)
            ->exists();

        return $userBelongsToProject
            ? $this->allow()
            : $this->deny();
    }
}