<?php

declare(strict_types=1);

namespace App\Services\ChatGpt;

interface ChatGptServiceInterface
{
    /**
     * @return array<string, mixed>
     */
    public function fetchSubtasks(string $prompt): array;
}
