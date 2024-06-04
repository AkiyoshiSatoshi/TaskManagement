<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user): Response
    {
        return $user->role === 1
            ? $this->allow()
            : $this->deny();
    }

    public function store(User $user): Response
    {
        return $user->role === 1
            ? $this->allow()
            : $this->deny();
    }

    public function show(User $user): Response
    {
        return $user->role === 1
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user): Response
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
