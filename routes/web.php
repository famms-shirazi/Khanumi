<?php

use App\Http\Controllers\ShoppingCartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Faker\Factory as Faker;


Route::get('/', function () {
    return view('welcome');
});
Route::get('test',function (){
    $faker = Faker::create('fa_IR');
    $product_name = $faker->word();
    dd($product_name);
});
Route::resource('brands',BrandController::class);
Route::resource('users',UserController::class);
Route::resource('products',ProductController::class);
Route::resource('shopping-carts',ShoppingCartController::class);
Route::post('login', [AuthController::class,'login']);

Route::get('logout',[AuthController::class,'logOut']);
Route::get('csrf-token', [UserController::class, 'getCsrfToken']);

