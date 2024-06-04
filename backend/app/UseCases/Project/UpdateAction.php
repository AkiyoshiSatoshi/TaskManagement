<?php

declare(strict_types=1);

namespace App\UseCases\Project;

use App\Models\Project;

class UpdateAction
{
    public function __invoke(Project $project): Project
    {
        $project->save();

        return $project;
    }
}
