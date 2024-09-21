<?php

namespace App\Actions\User;

use App\Actions\Auth\RespondWithTokenAction;
use App\Data\CreateUserData;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class CreateUserAction
{
    public function __construct(
        public RespondWithTokenAction $respondWithTokenAction
    ) {
    }

    public function execute(CreateUserData $createUserData)
    {
        $user = User::create([
            'email' => $createUserData->email,
            'password' => $createUserData->password,
            'name' => $createUserData->name,
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        event(new Registered($user));

        return $this->respondWithTokenAction->execute($token);
    }
}
