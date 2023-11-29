<?php

namespace App\Http\Controllers;

use App\Actions\Auth\RespondWithTokenAction;
use App\Actions\Auth\UserLoginAction;
use App\Actions\Auth\UserLogoutAction;
use App\Actions\User\CreateUserAction;
use App\Data\CreateUserData;
use App\Data\LoginUserData;
use App\Exceptions\MessageException;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    public function login(
        UserLoginAction $userLoginAction,
        LoginUserData $loginUserData
    )
    {
        $response = $userLoginAction->execute($loginUserData);

        return Response::success(
            message: '',
            data: $response,
        );
    }

    public function me()
    {
        $user = UserResource::make(Auth::user());
        return Response::success(
            data: $user
        );
    }

    public function logout()
    {
        auth()->logout();

        return Response::success(
            message: trans('messages.successfully_logged_out')
        );
    }

    public function refresh(
        RespondWithTokenAction $respondWithTokenAction,
    ) {
        $token = JWTAuth::getToken();

        if (! $token) {
            throw new MessageException(trans('message.token_not_provided'));
        }

        $response = $respondWithTokenAction->execute(Auth::refresh($token));

        return Response::success(
            message: '',
            data: $response,
        );
    }

    public function register(CreateUserData $createUserData, CreateUserAction $createUserAction)
    {
        $response = $createUserAction->execute($createUserData);

        return Response::success(
            message: trans('messages.user_created_successfully'),
            data: $response,
        );
    }
}
