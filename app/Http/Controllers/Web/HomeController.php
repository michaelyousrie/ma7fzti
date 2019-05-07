<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if ( Auth::check() ){
            return view("homepage", ['user' => Auth::user()]);
        }
        
        return redirect(route('login.show'));
    }
}
