<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeCategoryResource;

class IncomeCategoriesController extends Controller
{
    public function index()
    {
        return IncomeCategoryResource::collection( $this->user->incomeCategories );
    }
}
