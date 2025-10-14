<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

// route resource
Route::resource('/products', ProductController::class);
Route::resource('/transactions', TransactionController::class);
Route::resource('/suppliers', SupplierController::class);
Route::resource('/categories', CategoryController::class);
