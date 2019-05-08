<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if ( Auth::check() ) {
            $user = Auth::user();

            $user->incomes = $user->getIncomes();
            $user->expenses = $user->getExpenses();

            return view("homepage", compact('user'));
        }
        
        return redirect(route('login.show'));
    }
}
