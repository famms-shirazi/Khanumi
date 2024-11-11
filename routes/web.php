<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('brands',BrandController::class);
Route::resource('users',UserController::class);
Route::post('login', [AuthController::class,'login']);
Route::get('logout',[AuthController::class,'logOut']);
Route::get('csrf-token', [UserController::class, 'getCsrfToken']);

