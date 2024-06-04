<?php

declare(strict_types=1);

namespace App\UseCases\Project;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    public function __invoke(User $user): Collection
    {
        $projects = $user
            ->projects()
            ->with('users')
            ->get();

        return $projects;
    }
}
