<?php

namespace App\Http\Controllers\Api;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\LanguagesTransformer;

class LanguagesController extends Controller
{
    public function index()
    {
        $transformer = new LanguagesTransformer( collect( Language::all() ) );

        return $transformer->transform();
    }
}
