<?php

namespace App\Http\Controllers\Web\Auth;

use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        $langs = Language::all();

        return view("auth.register", compact( 'langs' ));
    }


    public function store( RegisterRequest $request )
    {
        $user = new User([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'balance'           => 0,
            'currency'          =>  $request->currency,
            'app_version'       => '1.0',
            'language_code'     => $request->language_code,
            'api_token'         => Str::random(20),
            'remember_token'    => Str::random(10)
        ]);

        $user->save();

        Auth::login( $user );

        return redirect( "/" );
    }
}
