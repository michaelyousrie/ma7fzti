<?php

use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace( 'Api' )->prefix('v1')->group(function() {
    Route::get('/expenses', 'ExpensesController@index');
    Route::get('/languages', 'LanguagesController@index');
});
