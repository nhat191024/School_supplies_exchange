<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ReviewController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

Route::apiResource('users', UserController::class);
Route::post('/users/profile', [UserController::class, 'update'])->middleware('auth:sanctum');

Route::apiResource('categories', CategoryController::class);

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/products/update/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

Route::get('/products/user/postProduct', [ProductController::class, 'postByUser'])->middleware('auth:sanctum');

Route::get('/bills/{type}', [BillController::class, 'index'])->middleware('auth:sanctum');

Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth:sanctum');
