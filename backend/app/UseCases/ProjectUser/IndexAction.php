<?php

declare(strict_types=1);

namespace App\UseCases\ProjectUser;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    public function __invoke(Project $project): Collection
    {
        $users = $project->users;
        // @phpstan-ignore-next-line
        assert($users->exists);

        return $users;
    }
}
