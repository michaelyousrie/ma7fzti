<?php

Route::get('/', "Web\HomeController@index")->name('home');

Route::get('/login', "Web\Auth\LoginController@show")->name('login.show')->middleware("NotLoggedIn");
Route::post("/login", "Web\Auth\LoginController@store")->name('login.store')->middleware("NotLoggedIn");

Route::get('/register', "Web\Auth\RegisterController@show")->name('register.show')->middleware("NotLoggedIn");
Route::post("/register", "Web\Auth\RegisterController@store")->name('register.store')->middleware("NotLoggedIn");
