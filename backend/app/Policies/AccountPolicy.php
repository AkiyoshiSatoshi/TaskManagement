<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AccountPolicy
{
    use HandlesAuthorization;

    public function update(User $user): Response
    {
        return $user->role === 1
            ? $this->allow()
            : $this->deny();
    }
}
