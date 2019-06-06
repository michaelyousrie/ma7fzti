<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    public function store( LoginRequest $request )
    {
        $user = User::where('email', $request->email)->first();

        $verify = password_verify($request->password, $user->password);

        if ( ! $verify ) {
            return [
                'errors'    => [
                    "password" => [ "Wrong Password!" ]
                ]
            ];
        }

        $user->api_token = Str::random(20);
        $user->save();

        Auth::login($user);

        return new UserResource($user);
    }
}
