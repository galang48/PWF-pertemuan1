<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController as CategoryApiController;
use App\Http\Controllers\Api\ProductController as ProductApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'getToken']);

    Route::get('/product', [ProductApiController::class, 'index']);
    Route::get('/product/{id}', [ProductApiController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::post('/product', [ProductApiController::class, 'store']);
        Route::put('/product/{id}', [ProductApiController::class, 'update']);
        Route::delete('/product/{id}', [ProductApiController::class, 'destroy']);

        Route::get('/category', [CategoryApiController::class, 'index']);
        Route::post('/category', [CategoryApiController::class, 'store']);
        Route::get('/category/{id}', [CategoryApiController::class, 'show']);
        Route::put('/category/{id}', [CategoryApiController::class, 'update']);
        Route::delete('/category/{id}', [CategoryApiController::class, 'destroy']);
    });
});
