<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\SellerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    //Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'v1'], function () {
    Route::middleware('auth:sanctum')->group(function () {
        // Sellers routes
        Route::group(['middleware' => 'role:admin', 'prefix' => '/sellers'], function () {
            Route::get('/get', [SellerController::class, 'getSellers']);
            Route::post('/create', [SellerController::class, 'createSeller']);
            Route::put('/{id}/update', [SellerController::class, 'updateSeller']);
            Route::delete('/{id}/delete', [SellerController::class, 'deleteSeller']);
        });

        // Products & attributes routes
        Route::group(['middleware' => 'role:seller,manager', 'prefix' => '/products'], function () {
            Route::get('/get', [ProductController::class, 'getProducts']);
            Route::post('/create', [ProductController::class, 'createProduct']);
            Route::put('/{id}/update', [ProductController::class, 'updateProduct']); // Менеджеры и продавцы могут обновлять
            Route::delete('/{id}/delete', [ProductController::class, 'deleteProduct']);
        });

        // Categories
        Route::group(['middleware' => 'role:manager', 'prefix' => '/categories'], function () {
            Route::get('/get', [CategoryController::class, 'getCategories']);
            Route::post('/create', [CategoryController::class, 'createCategory']);
            Route::put('/{id}/update', [CategoryController::class, 'updateCategory']);
            Route::delete('/{id}/delete', [CategoryController::class, 'deleteCategory']);
        });

        // Products for moderation
        Route::group(['middleware' => 'role:manager', 'prefix' => '/products'], function () {
            Route::get('/get-for-moderation', [ProductController::class, 'getProductsForModeration']);
            Route::put('{id}/approve', [ProductController::class, 'approveProduct']);
            Route::put('{id}/reject', [ProductController::class, 'rejectProduct']);
        });
    });
});
