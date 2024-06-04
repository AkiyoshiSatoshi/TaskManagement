<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\User;

class ShowAction
{
    public function __invoke(User $user): User
    {
        assert($user->exists);

        $user->can('show');

        return $user;
    }
}
