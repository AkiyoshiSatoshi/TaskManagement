<?php

declare(strict_types=1);

namespace App\UseCases\Account;

use App\Models\User;

class UpdateMyAccountAction
{
    public function __invoke(User $user): User
    {
        $user->save();

        return $user;
    }
}
