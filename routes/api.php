<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/products/{id?}', [
	'as' => 'products-list', 
	'uses' => 'FarmerProductController@index'
]);

Route::middleware('auth:api')->get('/product/{id}', [
	'as' => 'product-show',
	'uses' => 'FarmerProductController@show'
]);

Route::middleware('auth:api')->post('/product/add', [
	'as' => 'product-add',
	'uses' => 'FarmerProductController@store'
]);

Route::middleware('auth:api')->get('/users/{type?}', [
	'as' => 'users-list',
	'uses' => 'UserController@index'
]);

Route::middleware('auth:api')->get('/user/{id}', [
	'as' => 'user-show',
	'uses' => 'UserController@show'
]);

Route::middleware('auth:api')->post('/order/new', [
	'as' => 'order-new',
	'uses' => 'OrderController@store'
]);

Route::middleware('auth:api')->post('/cart/add', [
	'as' => 'cart-add',
	'uses' => 'ProductOrderController@store'
]);
