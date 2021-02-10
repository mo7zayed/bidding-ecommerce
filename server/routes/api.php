<?php

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

Route::post('auth/login', 'Auth\AuthController@login');
Route::post('auth/register', 'Auth\AuthController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        // JWT auth uri's
        Route::post('logout', 'Auth\AuthController@logout');
        Route::post('refresh', 'Auth\AuthController@refresh');
        Route::post('me', 'Auth\AuthController@me');
    });

    Route::resource('cart', 'Cart\CartController', [
        'parameters' => [
            'cart' => 'productVariation'
        ],
    ]);

    Route::post('bid/{product}', 'Bidding\BiddingController@store');

    Route::apiResource('addresses', 'Addresses\AddressesController');
});

Route::apiResource('categories', 'Categories\CategoriesController');
Route::apiResource('products', 'Products\ProductsController');
