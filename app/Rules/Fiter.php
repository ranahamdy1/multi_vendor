<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Fiter implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

    }

    protected $forbiddenNames;
    public function __construct(array $forbiddenNames)
    {
        $this->forbiddenNames = $forbiddenNames;
    }

    public function passes($attribute, $value)
    {
        return !in_array(strtolower($value) , $this->forbiddenNames);
    }
    public function message(): string
    {
        return 'this function is not allowed';
    }
}
