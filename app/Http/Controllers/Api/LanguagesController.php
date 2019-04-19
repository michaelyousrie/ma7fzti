<?php

namespace App\Http\Controllers\Api;

use App\Models\Language;
use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;

class LanguagesController extends Controller
{
    public function index()
    {
        return LanguageResource::collection( Language::all() );
    }
}
