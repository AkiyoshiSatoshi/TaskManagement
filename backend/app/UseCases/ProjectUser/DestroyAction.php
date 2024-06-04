<?php

declare(strict_types=1);

namespace App\UseCases\ProjectUser;

use App\Exceptions\LastUserDeletedException;
use App\Models\Project;
use App\Models\User;

class DestroyAction
{
    public function __invoke(Project $project, User $user): void
    {
        if ($project->users()->count() <= 1) {
            throw new LastUserDeletedException('最後のユーザーは削除できません');
        }

        $project->users()->detach($user->id);
    }
}
