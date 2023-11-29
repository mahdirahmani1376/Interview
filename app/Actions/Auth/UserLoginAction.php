<?php

namespace App\Actions\Auth;

use App\Data\LoginUserData;
use App\Exceptions\MessageException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserLoginAction
{
    public function __construct(
        public RespondWithTokenAction $respondWithTokenAction
    ) {
    }

    public function execute(LoginUserData $loginUserData)
    {
        $manager = $loginUserData->getManager();

        if (! $manager) {
            throw new MessageException(
                message: trans('messages.user_information_is_incorrect'),
                code: Response::HTTP_BAD_REQUEST
            );
        }

        $token = Auth::attempt([
            'email' => $manager->email,
            'password' => $loginUserData->password,
        ]);

        if (! $token) {
            throw new MessageException(
                message: trans('messages.user_information_is_incorrect'),
                code: Response::HTTP_BAD_REQUEST
            );
        }

        return $this->respondWithTokenAction->execute($token);
    }
}
