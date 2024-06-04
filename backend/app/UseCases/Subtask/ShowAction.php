<?php

declare(strict_types=1);

namespace App\UseCases\Subtask;

use App\Models\Subtask;

class ShowAction
{
    public function __invoke(Subtask $subtask): Subtask
    {
        assert($subtask->exists);

        return $subtask;
    }
}
