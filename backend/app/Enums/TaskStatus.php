<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskStatus: int
{
    case INCOMPLETE = 1;
    case COMPLETED = 10;

    public function label(): string
    {
        return match ($this) {
            self::INCOMPLETE => '未完了',
            self::COMPLETED => '完了済み',
        };
    }
}