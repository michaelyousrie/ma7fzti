<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function show()
    {
        return view("auth.login");
    }


    public function store( Request $request )
    {
        $request = Request::create("api/v1/login", "POST", $request->toArray());

        $response = json_decode( Route::dispatch($request)->getContent() );

        $errors = false;

        if ( property_exists($response, "errors") ) {
            $errors = true;
            foreach( $response->errors as $key => $value ) {
                foreach($value as $error) {
                    $errors = session()->get("errors", []);

                    if ( array_key_exists($key, $errors) ) {
                        $errors[$key][] = $error;
                    } else {
                        $errors[$key] = [$error];
                    }

                    session()->put("errors", $errors);
                }
            }
        }

        if ( $errors ) return redirect(route('login.show'));

        return redirect(route('home'));
    }
}
