<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidMobile implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        return (bool) preg_match('/^09[0-9]{9}$/', (string) $value);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'شماره موبایل نامعتبر است. شماره موبایل باید با 09 شروع بشود و بدون فاصله وارد شود.';
    }
}
