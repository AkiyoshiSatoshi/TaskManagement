<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'integer', 'in:1,10'],
            'detail' => ['string', 'max:1000'],
        ];
    }

    public function makeTask(Task $task): Task
    {
        $task->fill($this->validated());

        return $task;
    }
}
