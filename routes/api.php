<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;


Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/cart/add', [CartController::class, 'add']);
    // ✅ Add this route for saving favorites
   
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products/favorites', [WishlistController::class, 'saveFavorite']);
});

