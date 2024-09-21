<?php

namespace App\Http\Controllers;

use App\Actions\Auth\RespondWithTokenAction;
use App\Actions\Auth\UserLoginAction;
use App\Actions\User\CreateUserAction;
use App\Data\CreateUserData;
use App\Data\LoginUserData;
use App\Exceptions\MessageException;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="User login",
     *     description="Logs in a user and returns authentication data.",
     *     operationId="loginUser",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="username", type="string", description="The username of the user", example="john_doe"),
     *             @OA\Property(property="password", type="string", description="The password of the user", example="Password123!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent()
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request - Invalid input",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Authentication failed",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function login(
        UserLoginAction $userLoginAction,
        LoginUserData $loginUserData
    ) {
        $response = $userLoginAction->execute($loginUserData);

        return Response::success(
            message: '',
            data: $response,
        );
    }

    /**
     * @OA\Get(
     *     path="/api/auth/me",
     *     summary="User information",
     *     operationId="me",
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function me()
    {
        $user = UserResource::make(Auth::user());

        return Response::success(
            data: $user
        );
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Log out the authenticated user",
     *     description="Logs out the currently authenticated user by invalidating their token.",
     *     operationId="logoutUser",
     *     tags={"Auth"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Successfully logged out"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Unauthenticated."
     *             )
     *         )
     *     )
     * )
     */

    public function logout()
    {
        auth()->logout();

        return Response::success(
            message: trans('messages.successfully_logged_out')
        );
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     summary="Refresh the user's authentication token",
     *     description="Revokes the current token and issues a new authentication token for the user.",
     *     operationId="refreshToken",
     *     tags={"Auth"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example=""
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="token",
     *                     type="string",
     *                     description="The new authentication token",
     *                     example="1|e14bd3a0f5b94823b7cd58f287e5ec11e38cbbcd3ab6fbdf63508e5a07f9fbd4"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - User is not authenticated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Unauthenticated."
     *             )
     *         )
     *     )
     * )
     */
    public function refresh(
        RespondWithTokenAction $respondWithTokenAction,
    ) {
        $user = Auth::user();

        if (! $user) {
            throw new MessageException(
                trans('message.unauthenticated'),
                Response::HTTP_UNAUTHORIZED
            );
        }

        $user->currentAccessToken()->delete();

        $newToken = $user->createToken('API Token')->plainTextToken;

        $response = $respondWithTokenAction->execute($newToken);

        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $response,
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register a new user",
     *     description="Creates a new user account and returns the created user's details.",
     *     operationId="registerUser",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="The name of the user", example="John Doe"),
     *             @OA\Property(property="email", type="string", description="The email address of the user", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", description="The password for the user account", example="Password123!"),
     *             @OA\Property(property="password_confirmation", type="string", description="Confirm the password", example="Password123!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="User created successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="john.doe@example.com"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request - Validation errors",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             )
     *         )
     *     )
     * )
     */
    public function register(CreateUserData $createUserData, CreateUserAction $createUserAction)
    {
        $response = $createUserAction->execute($createUserData);

        return Response::success(
            message: trans('messages.user_created_successfully'),
            data: $response,
        );
    }
}
