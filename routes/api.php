<?php

use Illuminate\Http\Request;

Route::get('/', function()
{
    return 'Hello';
});

Route::resource('users', 'UserController')->except('create', 'edit');
Route::resource('contacts', 'ContactController')->except('create', 'edit', 'show');

Route::post('auth', 'AuthController@Login');
Route::get('auth', 'AuthController@GetCurrentUser');