<?php

use Illuminate\Http\Request;
use App\Contact;
use App\Http\Resource\ContactCollection;

Route::get('/', function()
{
    return 'Hello';
});

Route::get('/contacts', function()
{
    return new ContactCollection(Contact::all());
});
