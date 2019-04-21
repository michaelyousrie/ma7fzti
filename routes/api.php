<?php

Route::namespace( 'Api' )->prefix('v1')->group(function() {
    Route::get('/languages', 'LanguagesController@index');

    Route::get('/user/expenses', 'ExpensesController@index');
    Route::get('/user/expenses/{id}', 'ExpensesController@show');
    Route::patch('/user/expenses/{id}', 'ExpensesController@update');

    Route::get('/user/incomes', 'IncomesController@index');
    Route::get('/user/incomes/{id}', 'IncomesController@show');
    Route::patch('/user/incomes/{id}', 'IncomesController@update');

    Route::get('/user/income_categories', 'IncomeCategoriesController@index');
    Route::get('/user/income_categories/{id}', 'IncomeCategoriesController@show');
    
    Route::get('/user/expense_categories', 'ExpenseCategoriesController@index');
    Route::get('/user/expense_categories/{id}', 'ExpenseCategoriesController@show');
    
    Route::get('/user', 'UsersController@index');

    Route::post('/user/income_categories', 'IncomeCategoriesController@store');
    Route::post('/user/expense_categories', 'ExpenseCategoriesController@store');

    Route::post('/expenses', 'ExpensesController@store');
    Route::post('/incomes', 'IncomesController@store');

    Route::post('/login', 'LoginController@store');
    Route::post('/register', 'RegisterController@store');
});
