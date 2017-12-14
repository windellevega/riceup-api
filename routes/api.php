<?php

use Illuminate\Http\Request;

/*
--------------------------
ROUTES FOR PRODUCT METHODS
--------------------------
*/

//Show list of products.
//Optional: id - to filter products per user
Route::middleware('auth:api')->get('/products/{id?}', [
	'as' => 'products-list', 
	'uses' => 'FarmerProductController@index'
]);

//Show product detail
//Required: id - product id
Route::middleware('auth:api')->get('/product/{id}', [
	'as' => 'product-show',
	'uses' => 'FarmerProductController@show'
]);

//Add product
Route::middleware('auth:api')->post('/product/add', [
	'as' => 'product-add',
	'uses' => 'FarmerProductController@store'
]);

//Remove product
//Required: id - product id
Route::middleware('auth:api')->delete('/product/remove/{id}', [
    'as' => 'product-remove',
    'uses' => 'FarmerProductController@destroy'
]);


/*
-----------------------
ROUTES FOR USER METHODS
-----------------------
*/

//User registration
Route::middleware('auth:api')->post('/user/register', [
	'as' => 'user-register',
	'uses' => 'UserController@store'
]);

//Show list of users
//Optional: type - to filter users per type (farmer or user)
Route::middleware('auth:api')->get('/users/{type?}', [
	'as' => 'users-list',
	'uses' => 'UserController@index'
]);

//Show details of a user
//Optional: id - returns detail specific user otherwise the logged-in user
Route::middleware('auth:api')->get('/user/{id?}', [
	'as' => 'user-show',
	'uses' => 'UserController@show'
]);


/* 
------------------------
ROUTES FOR ORDER METHODS
------------------------
*/

//Initializes a new order
Route::middleware('auth:api')->post('/order/new', [
	'as' => 'order-new',
	'uses' => 'OrderController@store'
]);

//Retrieves the list of orders per user
Route::middleware('auth:api')->get('/orders', [
	'as' => 'orders-list', 
	'uses' => 'OrderController@index'
]);

//Shows details of a specific order
//Required: id - order id
Route::middleware('auth:api')->get('/order/{id}', [
	'as' => 'order-show',
	'uses' => 'OrderController@show'
]);


/*
-----------------------
ROUTES FOR CART METHODS
-----------------------
*/

//Add specific product to cart
Route::middleware('auth:api')->post('/cart/add', [
	'as' => 'cart-add',
	'uses' => 'ProductOrderController@store'
]);

//Edit product quantity
Route::middleware('auth:api')->patch('/cart/update/{id}', [
    'as' => 'cart-update',
    'uses' => 'ProductOrderController@update'
]);

//Remove product from cart
Route::middleware('auth:api')->delete('/cart/remove/{id}', [
    'as' => 'cart-remove',
    'uses' => 'ProductOrderController@destroy'
]);