<?php

declare(strict_types=1);

namespace App\UseCases\Task;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    public function __invoke(Project $project): Collection
    {
        return Task::where('project_id', $project->id)->with('subtasks')->get();
    }
}
