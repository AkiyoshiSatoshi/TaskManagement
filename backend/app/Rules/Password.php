<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Password implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[.!#$%&'*+\/=?^_`{|}~-])[A-Za-z\d.!#$%&'*+\/=?^_`{|}~-]+$/", $value)) {
            $fail("{$attribute}に正しい形式を指定してください");
        }
    }
}
