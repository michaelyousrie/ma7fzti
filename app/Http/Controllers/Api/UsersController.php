<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    public function index()
    {
        return new UserResource($this->user);
    }


    public function update( UpdateUserRequest $request )
    {
        $this->user->first_name = $request->first_name;
        $this->user->last_name = $request->last_name;
        $this->user->email = $request->email;
        $this->user->password = bcrypt( $request->password );
        $this->user->language_code = $request->language_code;

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
