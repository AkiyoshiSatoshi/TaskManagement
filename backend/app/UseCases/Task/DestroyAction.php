<?php

declare(strict_types=1);

namespace App\UseCases\Task;

use App\Models\Task;

class DestroyAction
{
    public function __invoke(Task $task): void
    {
        $task->delete();
    }
}
