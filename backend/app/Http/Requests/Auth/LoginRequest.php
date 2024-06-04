<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Rules\Email;
use App\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['string', 'required', 'max:255', new Email()],
            'password' => ['string', 'required', 'min:10', 'max:255', new Password()],
        ];
    }
}
