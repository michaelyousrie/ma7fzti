<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\ExpensesTransformer;

class ExpensesController extends Controller
{
    public function index( Request $request )
    {
        $transformer = new ExpensesTransformer( $this->user->expenses );
        
        return $transformer->transform();
    }
}
