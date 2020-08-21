<?php

use App\Models\Category;

Route::resource('categories', 'Categories\CategoryController');
Route::resource('products', 'Products\ProductController');
Route::resource('addresses', 'Addresses\AddressController');
Route::get('addresses/{address}/shipping', 'Addresses\AddressShippingController@action');
Route::resource('orders', 'Orders\OrderController');

Route::group(['prefix' => 'auth'], function () {

    Route::post('register', 'Auth\RegisterController@action');
    Route::post('login', 'Auth\LoginController@action');
    Route::get('profile', 'Auth\ProfileController@action');
});


Route::resource('cart', 'Cart\CartController', [
    'parameters' => [
        'cart' => 'productVariation'
    ]
]);
