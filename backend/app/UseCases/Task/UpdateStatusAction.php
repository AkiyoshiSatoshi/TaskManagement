<?php

declare(strict_types=1);

namespace App\UseCases\Task;

use App\Models\Task;

class UpdateStatusAction
{
    public function __invoke(Task $task): Task
    {
        $task->save();

        return $task;
    }
}
