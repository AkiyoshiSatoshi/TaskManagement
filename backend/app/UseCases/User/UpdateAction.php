<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\User;

class UpdateAction
{
    public function __invoke(User $user): User
    {
        assert($user->exists);

        $user->save();

        return $user;
    }
}
