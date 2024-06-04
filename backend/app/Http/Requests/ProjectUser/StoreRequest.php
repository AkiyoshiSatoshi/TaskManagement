<?php

declare(strict_types=1);

namespace App\Http\Requests\ProjectUser;

use App\Models\ProjectUser;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(Gate $gate): bool
    {
        $user = $this->user();

        return $gate->authorize('store', [ProjectUser::class, $user])->allowed();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'users' => ['required', 'array'],
        ];
    }

    public function makeProjectUser(): ProjectUser
    {
        return new ProjectUser($this->validated());
    }
}
