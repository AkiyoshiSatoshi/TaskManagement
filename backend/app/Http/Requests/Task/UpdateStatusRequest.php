<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use TypeError;

class UpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'integer', 'in:1,10'],
        ];
    }

    public function makeTask(Task $task): Task
    {
        if (! $task instanceof Task) {
            throw new TypeError('型エラー');
        }

        $task->fill($this->validated());
        $task->status = $task->status === 1 ? 10 : 1;

        return $task;
    }
}
