<?php

declare(strict_types=1);

namespace App\UseCases\Task;

use App\Models\Task;

class UpdateAction
{
    public function __invoke(Task $task): Task
    {
        assert($task->exists);

        $task->save();

        return $task;
    }
}
