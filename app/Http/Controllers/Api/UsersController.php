<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return new UserResource($this->user);
    }


    public function update( UpdateUserRequest $request )
    {
        if ( ! Hash::check( $request->password, $this->user->password ) )
            return response( ["errors" => [ "password" => "Your password is wrong!" ]], 422 );

        $this->user->first_name = $request->first_name;
        $this->user->last_name = $request->last_name;
        $this->user->email = $request->email;
        $this->user->language_code = $request->language_code;
        $this->user->currency = $request->currency;

        if ( ! empty( $request->new_password ) )
            $this->user->password = bcrypt( $request->new_password );

        $this->user->save();

        return new UserResource($this->user);
    }


    public function frontEndIndex()
    {
        return successResponse([
            'user'  => getUserObject()
        ]);
    }
}
