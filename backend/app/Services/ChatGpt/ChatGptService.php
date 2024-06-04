<?php

declare(strict_types=1);

namespace App\Services\ChatGpt;

use OpenAI\Laravel\Facades\OpenAI;

class ChatGptService implements ChatGptServiceInterface
{
    /**
     * @return array<string, mixed>
     */
    public function fetchSubtasks(string $prompt): array
    {
        $response = OpenAI::completions()->create([
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => $prompt,
            'max_tokens' => 256,
            'temperature' => 0,
            'top_p' => 1,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        return json_decode($response['choices'][0]['text'], true);
    }
}
