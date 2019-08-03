<?php
/*
--------------------------
ACCOUNT ROUTES
--------------------------
*/
Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('forgot', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

/*
-----------------------
ROUTES FOR USER METHODS
-----------------------
*/

//User registration
Route::post('/user/register', 'UserController@store');

Route::group([
	'middleware' => 'auth:api'
], function() {
		/*
	--------------------------
	ROUTES FOR PRODUCT METHODS
	--------------------------
	*/

	//Show list of products.
	//Optional: id - to filter products per user
	Route::get('/products/{id?}', 'FarmerProductController@index');

	//Show list of products by category.
	//Optional: id - to filter products per category
	Route::get('/products-by-category/{id?}', 'FarmerProductController@productsByCategory');

	//Show product categories
	Route::get('/product/categories', 'FarmerProductCategoryController@index');

	//Show product detail
	//Required: id - product id
	Route::get('/product/{id}', 'FarmerProductController@show');

	//Add product
	Route::post('/product/add', 'FarmerProductController@store');

	//Update product
	//Required: id - product id
	Route::patch('/product/update/{id}', 'FarmerProductController@update');

	//Remove product
	//Required: id - product id
	Route::delete('/product/remove/{id}', 'FarmerProductController@destroy');

	//Get User Favorite Farmers
	Route::get('/product/favorited-by/{id}', 'FarmerProductController@getFavoritedBy');

	/*
	-----------------------
	ROUTES FOR USER METHODS
	-----------------------
	*/

	//Show list of users
	//Optional: type - to filter users per type (farmer or user)
	Route::get('/users/{type?}', 'UserController@index');

	//Show details of a user
	//Optional: id - returns detail specific user otherwise the logged-in user
	Route::get('/user/{id?}', 'UserController@show');

	//Update User Profile
	Route::patch('/user/update', 'UserController@update');

	//Change password
	Route::patch('/user/changepass', 'UserController@changePassword');

	Route::post('/shippingdetail', 'UserController@storeShippingDetail');

	Route::patch('/shippingdetail/{id}', 'UserController@updateShippingDetail');

	Route::delete('/shippingdetail/{id}', 'UserController@destroyShippingDetail');

	Route::get('/shippingdetails', 'UserController@getShippingDetails');

	Route::get('/shippingdetail/{id}', 'UserController@getShippingDetail');

	//Get User Favorite Products
	Route::get('/favorite/products', 'UserController@getFavoriteProducts');

	//Add User Favorite Product
	Route::post('/favorite/product', 'UserController@addFavoriteProduct');

	//Remove User Favorite Product
	//Required: id - product id
	Route::delete('/favorite/product/{id}', 'UserController@deleteFavoriteProduct');

	//Get User Favorite Farmers
	Route::get('/favorite/farmers', 'UserController@getFavoriteFarmers');

	//Get User Favorite Farmers
	Route::get('/user/favorited-by/{id}', 'UserController@getFavoritedBy');

	//Add User Favorite Farmer
	Route::post('/favorite/farmer/', 'UserController@addFavoriteFarmer');

	//Remove User Favorite Farmer
	//Required: id - farmer id
	Route::delete('/favorite/farmer/{id}', 'UserController@deleteFavoriteFarmer');


	/* 
	------------------------
	ROUTES FOR ORDER METHODS
	------------------------
	*/

	//Initializes a new order
	Route::post('/order/new', 'OrderController@store');

	//Retrieves the list of orders per user
	Route::get('/orders', 'OrderController@index');

	//Shows details of a specific order
	//Required: id - order id
	Route::get('/order/{id}', 'OrderController@show');

	//Checkout specific order
	//Required: id - order id
	Route::patch('/order/checkout/{id}', 'OrderController@update');


	/*
	-----------------------
	ROUTES FOR CART METHODS
	-----------------------
	*/

	//Add specific product to cart
	Route::post('/cart/add', 'ProductOrderController@store');

	//Edit product quantity
	Route::patch('/cart/update/{id}', 'ProductOrderController@update');

	//Remove product from cart
	Route::delete('/cart/remove/{id}', 'ProductOrderController@destroy');

	Route::get('/cart/{id}', 'ProductOrderController@showWithCurrentStatus');

	//Retrieve products for dispatch
	Route::get('/fordispatch', 'ProductOrderController@displayProductsForDispatch');

	Route::get('/ordersperfarmer/{status?}', 'ProductOrderController@displayProductOrdersPerFarmer');

	//Dispatch product
	Route::patch('/product/dispatch/{id}', 'ProductOrderController@dispatchProduct');

	//Pack product
	Route::patch('/product/pack/{id}', 'ProductOrderController@packProduct');

	//Cancell product
	Route::patch('/product/cancel/{id}', 'ProductOrderController@cancelProduct');
});