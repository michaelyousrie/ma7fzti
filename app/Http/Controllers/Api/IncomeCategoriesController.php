<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeCategoryResource;
use App\Http\Requests\CreateIncomeCategoryRequest;
use App\Models\IncomeCategory;
use App\Http\Requests\UpdateIncomeCategoryRequest;
use PHPUnit\Framework\MockObject\Stub\Exception;

class IncomeCategoriesController extends Controller
{
    public function index()
    {
        return IncomeCategoryResource::collection( $this->user->incomeCategories );
    }


    public function store( CreateIncomeCategoryRequest $request )
    {
        $incomeCategory = new IncomeCategory([
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        $incomeCategory = $this->user->incomeCategories()->save( $incomeCategory );

        return new IncomeCategoryResource($incomeCategory);
    }


    public function show( $id )
    {
        $incomeCategory = $this->guard( IncomeCategory::class, $id);

        return new IncomeCategoryResource( $incomeCategory );
    }


    public function update( $id, UpdateIncomeCategoryRequest $request )
    {
        $incomeCategory = $this->guard( IncomeCategory::class, $id);

        $incomeCategory->name = $request->name;
        $incomeCategory->description = $request->description;

        $incomeCategory->save();

        return new IncomeCategoryResource( $incomeCategory );
    }


    public function destroy( $id )
    {
        try {
            $incomeCategory = $this->guard( IncomeCategory::class, $id );    
            $incomes = $incomeCategory->getIncomes();

            foreach( $incomes as $income ) {
                $income->delete();
            }
    
            $incomeCategory->delete();
    
            return successResponse();
        } catch( Exception $e ) {
            return failResponse();
        }
    }
}
