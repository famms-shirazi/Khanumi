<?php

use App\Http\Controllers\ColorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('colors',ColorController::class);
