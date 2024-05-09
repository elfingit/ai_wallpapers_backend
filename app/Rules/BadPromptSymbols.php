<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BadPromptSymbols implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match('~[\[\{\]\}]+~', $value) !== 0) {
            $fail(__('validation.bad_prompt_symbols', ['attribute' => $attribute]));
        }
    }
}
