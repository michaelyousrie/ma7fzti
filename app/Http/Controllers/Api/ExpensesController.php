<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\CreateExpenseRequest;

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
}
