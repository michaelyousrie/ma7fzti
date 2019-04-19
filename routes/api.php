<?php

Route::namespace( 'Api' )->prefix('v1')->group(function() {
    Route::get('/languages', 'LanguagesController@index');

    Route::get('/user/expenses', 'ExpensesController@index');
    Route::get('/user/incomes', 'IncomesController@index');
    Route::get('/user', 'UsersController@index');
});
