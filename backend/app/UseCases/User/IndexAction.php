<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class IndexAction
{
    public function __invoke(User $user): Collection
    {
        Log::debug('IndexAction');
        Log::debug(User::all());
        $user->can('view');

        return User::all();
    }
}
