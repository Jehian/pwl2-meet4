<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//route resouce for products
Route::resource('/products', \App\Http\Controllers\ProductController::class);
