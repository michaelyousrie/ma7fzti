<?php

namespace App\Http\Controllers\Api;

use App\Models\Income;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use App\Http\Requests\CreateIncomeRequest;

class IncomesController extends Controller
{
    public function index()
    {
        return IncomeResource::collection($this->user->incomes);
    }

    public function store( CreateIncomeRequest $request )
    {
        $income = new Income([
            'amount'        => $request->amount,
            'category_id'   => $request->category_id,
            'description'   => $request->description
        ]);

        $income = $this->user->incomes()->save($income);

        return new IncomeResource( $income );
    }


    public function show( $id )
    {
        $this->guard(new Income, $id);

        return new IncomeResource( Income::where('id', $id)->first() );
    }
}
