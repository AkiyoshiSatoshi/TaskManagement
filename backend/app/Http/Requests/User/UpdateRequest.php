<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(Gate $gate): bool
    {
        $user = $this->user();

        return $gate->authorize('update', [User::class, $user])->allowed();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'max:255'],
        ];
    }

    public function makeUser(User $user): User
    {
        $user->fill($this->validated());

        return $user;
    }
}
