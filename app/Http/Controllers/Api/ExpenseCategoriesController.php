<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseCategoryResource;

class ExpenseCategoriesController extends Controller
{
    public function index()
    {
        return ExpenseCategoryResource::collection( $this->user->expenseCategories );
    }
}
