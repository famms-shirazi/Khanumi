<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('addresses', AddressController::class);
Route::resource('brands', AddressController::class);
Route::resource('cities', AddressController::class);
Route::resource('colors', AddressController::class);
Route::resource('comments', AddressController::class);
Route::resource('discounts', AddressController::class);
Route::resource('files', AddressController::class);
Route::resource('likes', AddressController::class);
Route::resource('orders', AddressController::class);
Route::resource('order-details', AddressController::class);
Route::resource('products', AddressController::class);
Route::resource('product-categories', AddressController::class);
Route::resource('provinces', AddressController::class);
Route::resource('shopping-carts', AddressController::class);
Route::resource('transactions', AddressController::class);
Route::resource('users', AddressController::class);
Route::resource('wallets', AddressController::class);
