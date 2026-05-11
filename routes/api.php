<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\AuthController;

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Resources
Route::apiResource('brands', BrandController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-items', OrderItemController::class);
Route::apiResource('payments', PaymentController::class);
Route::apiResource('payment-methods', PaymentMethodController::class);
Route::apiResource('carts', CartController::class);
Route::apiResource('shipments', ShipmentController::class);

// Custom Routes
Route::get('/orders/{order}/items', [OrderController::class, 'items']);
Route::get('/users/{user}/orders', [OrderController::class, 'userOrders']);
Route::get('/categories/{category}/products', [CategoryController::class, 'products']);
Route::get('/products/brand/{brand}', [ProductController::class, 'byBrand']);
