<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;

class ExpensesController extends Controller
{
    public function index( Request $request )
    {
        return ExpenseResource::collection( $this->user->expenses );
    }
}
