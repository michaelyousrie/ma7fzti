<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseCategoryResource;
use App\Http\Requests\CreateExpenseCategoryRequest;
use App\Models\ExpenseCategory;
use App\Http\Requests\UpdateExpenseCategoryRequest;

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


    public function show( $id )
    {
        $this->guard( ExpenseCategory::class, $id);

        return new ExpenseCategoryResource( ExpenseCategory::where('id', $id)->first() );
    }


    public function update( $id, UpdateExpenseCategoryRequest $request )
    {
        $expenseCategory = $this->guard(ExpenseCategory::class, $id);

        $expenseCategory->name = $request->name;
        $expenseCategory->description = $request->description;

        $expenseCategory->save();

        return new ExpenseCategoryResource( $expenseCategory );
    }


    public function destroy( $id )
    {
        try {
            $expenseCategory = $this->guard( ExpenseCategory::class, $id );    
            $expenses = $expenseCategory->getExpenses();

            foreach( $expenses as $expense ) {
                $expense->delete();
            }
    
            $expenseCategory->delete();
    
            return successResponse();
        } catch( Exception $e ) {
            return failResponse();
        }
    }
}
