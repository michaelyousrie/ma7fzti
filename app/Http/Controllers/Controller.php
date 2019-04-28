<?php

namespace App\Http\Controllers;

use function App\Helpers\handleError;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected $user;

    public function __construct( Request $request )
    {
        if ( $request->path() != 'api/v1/login' && $request->path()!= 'api/v1/register' )
        {
            if ( ! $request->api_token ) handleError(403);
    
            $user = User::where('api_token', $request->api_token)->first();
    
            if ( ! $user ) handleError( 404, "User is not found!");
    
            $this->user = $user;
    
            Auth::login( $this->user );
        }
    }

    /**
     * @param string $model
     * @param int $id
     * @return mixed
     */
    protected function guard(string $model, int $id )
    {
        $guard = $model::where('user_id', $this->user->id)->where('id', $id)->first();

        if ( ! $guard ) handleError(403, "You are not authorized to access this!");

        return $guard;
    }
}
