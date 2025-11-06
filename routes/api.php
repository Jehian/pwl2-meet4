<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;


Route::apiResource('users', UserController::class);
Route::get('test', function () {
    return response()->json(['message' => 'API is Working!']);
});
Route::get('/products', [ProductController::class, 'apiIndex']);
Route::get('/products/{id}', [ProductController::class, 'apiShow']);