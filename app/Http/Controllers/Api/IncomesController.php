<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;

class IncomesController extends Controller
{
    public function index()
    {
        return IncomeResource::collection($this->user->incomes);
    }
}
