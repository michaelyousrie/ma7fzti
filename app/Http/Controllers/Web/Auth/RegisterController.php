<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function show()
    {
        return view("auth.register");
    }


    public function store()
    {
        // 
    }
}
