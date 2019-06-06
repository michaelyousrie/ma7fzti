<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;

class ExpensesController extends Controller
{
    public function index()
    {
        return ExpenseResource::collection( $this->user->expenses );
    }


    public function store( CreateExpenseRequest $request )
    {
        $expense = new Expense([
            'amount'        => $request->amount,
            'category_id'   => $request->category_id,
            'description'   => $request->description
        ]);

        $expense = $this->user->expenses()->save($expense);

        return new ExpenseResource( $expense );
    }

    public function show( $id )
    {
        $expense = $this->guard( Expense::class, $id);

        return new ExpenseResource( $expense );
    }


    public function update( $id, UpdateExpenseRequest $request )
    {
        $expense = $this->guard( Expense::class, $id);

        $expense->amount = $request->amount;
        $expense->category_id = $request->category_id;
        $expense->description = $request->description;

        $expense->save();

        return new ExpenseResource($expense);
    }


    public function destroy( $id )
    {
        try {
            $expense = $this->guard( Expense::class, $id );
    
            $expense->delete();
    
            return successResponse();
        } catch( \Exception $e ) {
            return failResponse();
        }
    }
}
