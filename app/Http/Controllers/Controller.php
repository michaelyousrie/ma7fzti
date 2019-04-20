<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Model;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected $user;

    public function __construct( Request $request )
    {
        if ( $request->path() != 'api/v1/login' && $request->path()!= 'api/v1/register' )
        {
            if ( ! $request->api_token ) abort(403);
    
            $user = User::where('api_token', $request->api_token)->first();
    
            if ( ! $user ) abort(404, "User not found!");
    
            $this->user = $user;
    
            Auth::login( $this->user );
        }
    }


    protected function guard( Model $model, int $id )
    {
        $guard = $model::where('user_id', $this->user->id)->where('id', $id)->first() ? True : False;

        if ( ! $guard ) abort(403, "You are not authorized to view this!");

        return True;
    }
}
