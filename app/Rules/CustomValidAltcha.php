<?php

namespace App\Rules;

use Closure;
use App\Http\Captcha\AltchaService;
use Illuminate\Contracts\Validation\ValidationRule;

class CustomValidAltcha implements ValidationRule
{
    protected AltchaService $altchaService;

    public function __construct()
    {
        $this->altchaService = app(AltchaService::class);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->altchaService->verify($value)) {
            $fail('Invalid captcha solution. Please try again.');
        }
    }
}
