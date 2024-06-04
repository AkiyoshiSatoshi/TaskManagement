<?php

declare(strict_types=1);

namespace App\UseCases\Subtask;

use App\Models\Subtask;

class DestroyAction
{
    public function __invoke(Subtask $subtask): void
    {
        assert($subtask->exists);

        $subtask->delete();
    }
}
