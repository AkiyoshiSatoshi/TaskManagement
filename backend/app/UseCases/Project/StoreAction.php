<?php

declare(strict_types=1);

namespace App\UseCases\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Str;

class StoreAction
{
    public function __invoke(User $user, Project $project): Project
    {
        $project->save();
        $project->users()->attach($user->id, ['id' => Str::uuid()->toString()]);

        return $project;
    }
}
