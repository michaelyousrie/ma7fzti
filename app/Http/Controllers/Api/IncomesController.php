<?php

namespace App\Http\Controllers\Api;

use App\Models\Income;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use App\Http\Requests\CreateIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;

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

        return ajaxResponse([
            'income' => new IncomeResource( $income )
        ]);
    }


    public function show( $id )
    {
        $this->guard( Income::class, $id);

        return new IncomeResource( Income::where('id', $id)->first() );
    }


    public function update( $id, UpdateIncomeRequest $request )
    {
        $income = $this->guard( Income::class, $id);

        $income->amount = $request->amount;
        $income->category_id = $request->category_id;
        $income->description = $request->description;

        $income->save();

        return new IncomeResource($income);
    }


    public function destroy( $id )
    {
        $income = $this->guard( Income::class, $id );

        $income->delete();

        return ajaxResponse();
    }
}
