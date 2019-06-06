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
        return successResponse([
            'incomes' => IncomeResource::collection($this->user->incomes)
        ]);
    }

    public function store( CreateIncomeRequest $request )
    {
        try {
            $income = new Income([
                'amount'        => $request->amount,
                'category_id'   => $request->category_id,
                'description'   => $request->description
            ]);
    
            $income = $this->user->incomes()->save($income);
    
            return successResponse([
                'income' => new IncomeResource( $income )
            ]);
        } catch ( \Exception $e ) {
            return failResponse();
        }
    }


    public function show( $id )
    {
        $income = $this->guard( Income::class, $id);

        return successResponse([
            'income' => new IncomeResource( $income ) 
        ]);
    }


    public function update( $id, UpdateIncomeRequest $request )
    {
        try {
            $income = $this->guard( Income::class, $id);
    
            $income->amount = $request->amount;
            $income->category_id = $request->category_id;
            $income->description = $request->description;
    
            $income->save();

            return successResponse([
                'income'    => new IncomeResource($income)
            ]);

        } catch ( \Exception $e ) {
            return failResponse();
        }
    }


    public function destroy( $id )
    {
        try {
            $income = $this->guard( Income::class, $id );
    
            $income->delete();
    
            return successResponse();
        } catch( \Exception $e ) {
            return failResponse();
        }
    }
}
