<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SampleController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('brands',BrandController::class);
Route::resource('users',UserController::class);
Route::get('csrf-token', [UserController::class, 'getCsrfToken']);

