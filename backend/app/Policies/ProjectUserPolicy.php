<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProjectUserPolicy
{
    use HandlesAuthorization;

    public function store(User $user): Response
    {
        return $user->role === 1
            ? $this->allow()
            : $this->deny();
    }

    public function destroy(User $user): Response
    {
        return $user->role === 1
            ? $this->allow()
            : $this->deny();
    }
}
