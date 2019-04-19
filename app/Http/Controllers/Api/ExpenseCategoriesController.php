<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseCategoryResource;
use App\Http\Requests\CreateExpenseCategoryRequest;
use App\Models\ExpenseCategory;

class ExpenseCategoriesController extends Controller
{
    public function index()
    {
        return ExpenseCategoryResource::collection( $this->user->expenseCategories );
    }


    public function store( CreateExpenseCategoryRequest $request )
    {
        $expenseCategory = new ExpenseCategory([
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        $expenseCategory = $this->user->expenseCategories()->save( $expenseCategory );

        return new ExpenseCategoryResource($expenseCategory);
    }
}
