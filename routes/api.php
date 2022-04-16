<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// prevent mixed content error in production
if (App::environment('production')) {
    URL::forceScheme('https');
}



// ----------------------- PUBLIC ROUTES -------

// register route 
Route::post('/register','Api\User\UserController@store');



// -------------------PROTECTED ROUTES -----------------
Route::group([ /* 'middleware'=>['auth:api'] */ ],function(){
    // users resource routes
    Route::apiResource('/users','Api\User\UserController');

});


