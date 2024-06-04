<?php

declare(strict_types=1);

namespace App\UseCases\Task;

use App\Models\Task;

class ShowAction
{
    public function __invoke(Task $task): Task
    {
        assert($task->exists);

        return $task;
    }
}
