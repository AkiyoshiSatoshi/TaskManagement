<?php

declare(strict_types=1);

namespace App\Http\Requests\Subtask;

use App\Models\Subtask;
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
            'detail' => ['string', 'max:1000'],
        ];
    }

    public function makeSubtask(Subtask $subtask): Subtask
    {
        $subtask->fill($this->validated());

        return $subtask;
    }
}
