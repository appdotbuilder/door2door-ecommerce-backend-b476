<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CreditController;
use App\Http\Controllers\Api\CreditStatusController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DocumentationController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\InventoryReportController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SalesReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Documentation
Route::get('/', [DocumentationController::class, 'index']);
Route::get('/health', [HealthController::class, 'index']);

// Public routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Cart management
    Route::apiResource('cart', CartController::class)->except(['show']);
    
    // Address management
    Route::apiResource('addresses', AddressController::class);
    
    // Order management
    Route::apiResource('orders', OrderController::class)->except(['edit', 'destroy']);
    
    // Credit management
    Route::apiResource('credit-applications', CreditController::class)->only(['index', 'store', 'show']);
    Route::get('/credit/status', [CreditStatusController::class, 'index']);
    
    // Admin routes (should have admin middleware in real app)
    Route::prefix('admin')->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index']);
        Route::get('reports/sales', [SalesReportController::class, 'index']);
        Route::get('reports/inventory', [InventoryReportController::class, 'index']);
        
        // Category management
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        
        // Product management
        Route::apiResource('products', ProductController::class)->except(['index', 'show']);
        
        // Order management
        Route::patch('orders/{order}', [OrderController::class, 'update']);
        Route::get('orders', [OrderController::class, 'index']);
        
        // Credit application management
        Route::patch('credit-applications/{creditApplication}', [CreditController::class, 'update']);
        Route::get('credit-applications', [CreditController::class, 'index']);
    });
});