<?php

namespace App\Actions\Auth;

use App\Http\Resources\UserResource;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;

class UserLogoutAction
{
    public function execute()
    {
        auth()->logout();
	}
}
