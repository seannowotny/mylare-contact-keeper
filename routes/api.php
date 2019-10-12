<?php

use Illuminate\Http\Request;

Route::get('/', function()
{
    return 'Hello';
});

Route::resource('users', 'UserController')->except('create', 'edit');

Route::post('auth', 'AuthController@Login');
Route::get('auth', 'AuthController@GetCurrentUser');