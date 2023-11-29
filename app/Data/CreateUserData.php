<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateUserData extends Data
{
    public function __construct(
        public string $email,
        public string $password,
        public string $name
    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email', 'max:255', 'string'],
            'password' => ['required', 'string', 'min:6'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
