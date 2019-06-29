<?php

Route::namespace( 'Api' )->prefix('v1')->group(function() {
    Route::get('/languages', 'LanguagesController@index');

    Route::get('/user/expenses', 'ExpensesController@index');
    Route::get('/user/expenses/{id}', 'ExpensesController@show');
    Route::patch('/user/expenses/{id}', 'ExpensesController@update');
    Route::delete('/user/expenses/{id}', 'ExpensesController@destroy');

    Route::get('/user/incomes', 'IncomesController@index');
    Route::get('/user/incomes/{id}', 'IncomesController@show');
    Route::patch('/user/incomes/{id}', 'IncomesController@update');
    Route::delete('/user/incomes/{id}', 'IncomesController@destroy');

    Route::get('/user/income_categories', 'IncomeCategoriesController@index');
    Route::get('/user/income_categories/{id}', 'IncomeCategoriesController@show');
    Route::patch('/user/income_categories/{id}', 'IncomeCategoriesController@update');
    Route::delete('/user/income_categories/{id}', 'IncomeCategoriesController@destroy');
    
    Route::get('/user/expense_categories', 'ExpenseCategoriesController@index');
    Route::get('/user/expense_categories/{id}', 'ExpenseCategoriesController@show');
    Route::patch('/user/expense_categories/{id}', 'ExpenseCategoriesController@update');
    
    Route::get('/user', 'UsersController@index');
    Route::get('/userForFrontEnd', 'UsersController@frontEndIndex');
    Route::patch('/user', 'UsersController@update');

    Route::post('/user/income_categories', 'IncomeCategoriesController@store');
    Route::post('/user/expense_categories', 'ExpenseCategoriesController@store');

    Route::post('/expenses', 'ExpensesController@store');
    Route::post('/incomes', 'IncomesController@store');

    Route::post('/login', 'LoginController@store');
    Route::post('/register', 'RegisterController@store');
});

Route::fallback(function(){
    \App\Helpers\handleError(404, 'Url is not found');
});
