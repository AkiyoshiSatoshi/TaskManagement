<?php

declare(strict_types=1);

namespace App\UseCases\Project;

use App\Models\Project;

class ShowAction
{
    public function __invoke(Project $project): Project
    {
        return $project;
    }
}
