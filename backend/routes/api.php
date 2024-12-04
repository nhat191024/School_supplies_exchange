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
Route::apiResource('products', ProductController::class);
// Route::apiResource('bills', BillController::class);
Route::get('/bills/{type}', [BillController::class, 'index']);
Route::apiResource('reviews', ReviewController::class);
