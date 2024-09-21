<?php

namespace App\Data;

use App\Models\User;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class LoginUserData extends Data
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'email' => ['required', 'email', Rule::exists('users', 'email'), 'max:255', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function getManager(): ?User
    {
        return User::whereEmail($this->email)->first();
    }
}
