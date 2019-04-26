<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeCategoryResource;
use App\Http\Requests\CreateIncomeCategoryRequest;
use App\Models\IncomeCategory;

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
        $this->guard(new IncomeCategory, $id);

        return new IncomeCategoryResource( IncomeCategory::where('id', $id)->first() );
    }
}
