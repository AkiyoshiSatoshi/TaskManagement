<?php

declare(strict_types=1);

namespace App\UseCases\Task;

use App\Models\Task;

class StoreAction
{
    public function __invoke(Task $task): Task
    {
        assert($task->exists);

        $task->save();

        return $task;
    }
}
