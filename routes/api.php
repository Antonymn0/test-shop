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
//login route
Route::post('/login','Api\Auth\AuthController@login');



// -------------------PROTECTED ROUTES -----------------
Route::group([  'middleware'=>['auth:api']  ],function(){
    //check if user is authenticated and token still valid
    Route::get('/check-if-user-authenticated','Api\Auth\AuthController@checkIfUserAuthenticated');
    // logout
    Route::get('/logout','Api\Auth\AuthController@logout');

    // users resource routes
    Route::apiResource('/users','Api\User\UserController');

    // Products resource routes    
    Route::apiResource('/products','Api\Product\ProductController');
    Route::get('/search/products-by-author/{author_name}','Api\Product\ProductController@searchProductsByAuthorName');
    Route::get('/search/products-by-product-name/{product_name}','Api\Product\ProductController@searchProductsByProductName');
    Route::get('/search/products-by-date/{date}','Api\Product\ProductController@searchProductsByDate');



});


