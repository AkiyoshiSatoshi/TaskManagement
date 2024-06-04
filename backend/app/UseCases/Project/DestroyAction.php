<?php

declare(strict_types=1);

namespace App\UseCases\Project;

use App\Models\Project;

class DestroyAction
{
    public function __invoke(Project $project): void
    {
        $project->users()->detach();
        $project->delete();
    }
}
