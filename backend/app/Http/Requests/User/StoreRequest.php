<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Models\User;
use App\Rules\Email;
use App\Rules\Password;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(Gate $gate): bool
    {
        $user = $this->user();

        return $gate->authorize('store', [User::class, $user])->allowed();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'max:255'],
            'email' => ['string', 'required', 'max:255', new Email()],
            'password' => ['string', 'required', 'min:10', 'max:255', new Password()],
        ];
    }

    public function makeUser(): User
    {
        return new User($this->validated());
    }
}
