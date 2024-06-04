<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\User;

class DestroyAction
{
    public function __invoke(User $user): void
    {
        assert($user->exists);

        $user->delete();
    }
}
