<?php

declare(strict_types=1);

namespace App\UseCases\Account;

use App\Models\User;

class FetchMyAccountAction
{
    public function __invoke(User $user): User
    {
        return $user;
    }
}
