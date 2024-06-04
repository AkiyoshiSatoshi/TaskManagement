<?php

declare(strict_types=1);

namespace App\UseCases\Subtask;

use App\Exceptions\SubtaskNotGeneratedException;
use App\Models\Subtask;
use App\Models\Task;
use App\Services\ChatGpt\ChatGptServiceInterface;

class StoreAction
{
    public function __construct(
        private readonly ChatGptServiceInterface $chaGptService
    ) {
    }

    public function __invoke(Task $task): Subtask
    {
        $title = $task->name;
        $detail = $task->detail;

        $prompt = "あなたは、優秀なPMです.\n
        以下のタスク名とタスク詳細をもとに、必ず3つのサブタスクを作成してください.\n
        タスク名：$title\n
        タスク詳細：$detail\n
        作成するサブタスクは以下の通りです.\n
        ・サブタスクのタイトル\n
        ・サブタスクの実装詳細（100文字以内）\n
        のみを以下の例のように絶対にJSONで出力してください.\n
        jsonのkeyは、nameとdetailで命名してください.\n
        JSON以外の出力は受け付けません.\n
        jsonを配列で返すことを忘れないでください.\n
        ";

        $subtasks = $this->chaGptService->fetchSubtasks($prompt);
        try {
            foreach ($subtasks as $generatedSubtask) {
                $subtask = new Subtask();
                $subtask->task_id = $task->id;
                $subtask->name = $generatedSubtask['name'];
                $subtask->detail = $generatedSubtask['detail'];
                $subtask->save();
            }
            return $subtask;
        } catch (\Throwable) {
            throw new SubtaskNotGeneratedException('ChatGPTからサブタスクが生成されませんでした.');
        }

    }
}
