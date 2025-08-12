<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DocumentationController extends Controller
{
    /**
     * Get API documentation overview.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Welcome to FreshDoor E-commerce API',
            'version' => '1.0.0',
            'description' => 'Door-to-door grocery delivery platform API',
            'documentation' => [
                'base_url' => url('/api'),
                'authentication' => 'Bearer token via Laravel Sanctum',
                'endpoints' => [
                    'public' => [
                        'GET /categories' => 'List all categories',
                        'GET /categories/{id}' => 'Get category details',
                        'GET /products' => 'List products with filtering and search',
                        'GET /products/{id}' => 'Get product details',
                    ],
                    'authenticated' => [
                        'GET /user' => 'Get authenticated user info',
                        'GET /cart' => 'Get user cart',
                        'POST /cart' => 'Add product to cart',
                        'PUT /cart/{id}' => 'Update cart item quantity',
                        'DELETE /cart/{id}' => 'Remove item from cart',
                        'GET /addresses' => 'List user addresses',
                        'POST /addresses' => 'Create new address',
                        'PUT /addresses/{id}' => 'Update address',
                        'DELETE /addresses/{id}' => 'Delete address',
                        'GET /orders' => 'List user orders',
                        'POST /orders' => 'Create new order from cart',
                        'GET /orders/{id}' => 'Get order details',
                        'GET /credit-applications' => 'List credit applications',
                        'POST /credit-applications' => 'Submit credit application',
                        'GET /credit/status' => 'Get current credit status',
                    ],
                    'admin' => [
                        'GET /admin/dashboard' => 'Admin dashboard statistics',
                        'GET /admin/reports/sales' => 'Sales reports',
                        'GET /admin/reports/inventory' => 'Inventory reports',
                        'POST /admin/categories' => 'Create category',
                        'PUT /admin/categories/{id}' => 'Update category',
                        'DELETE /admin/categories/{id}' => 'Delete category',
                        'POST /admin/products' => 'Create product',
                        'PUT /admin/products/{id}' => 'Update product',
                        'DELETE /admin/products/{id}' => 'Delete product',
                        'PATCH /admin/orders/{id}' => 'Update order status',
                        'PATCH /admin/credit-applications/{id}' => 'Review credit application',
                    ]
                ],
                'product_filters' => [
                    'search' => 'Filter by product name or description',
                    'category_id' => 'Filter by category ID',
                    'brand' => 'Filter by brand',
                    'min_price' => 'Minimum price filter',
                    'max_price' => 'Maximum price filter',
                    'sort_by' => 'Sort by field (name, price, created_at)',
                    'sort_order' => 'Sort direction (asc, desc)',
                    'per_page' => 'Items per page (default: 15)',
                ],
                'order_statuses' => ['pending', 'accepted', 'processing', 'shipped', 'delivered', 'cancelled'],
                'payment_methods' => ['cod', 'bank_transfer', 'qris'],
                'payment_statuses' => ['pending', 'paid', 'failed', 'cancelled'],
                'credit_statuses' => ['pending', 'approved', 'rejected'],
            ],
            'examples' => [
                'product_search' => '/api/products?search=indomie&category_id=1&min_price=5000&sort_by=price&sort_order=asc',
                'create_order' => 'POST /api/orders with delivery_address_id, delivery_date, delivery_time, payment_method, notes',
                'credit_application' => 'POST /api/credit-applications with requested_amount',
            ]
        ]);
    }


}