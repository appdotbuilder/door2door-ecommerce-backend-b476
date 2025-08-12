<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\CreditApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get admin dashboard statistics.
     */
    public function index(Request $request): JsonResponse
    {
        // Get date range (default to last 30 days)
        $startDate = $request->get('start_date', now()->subDays(30));
        $endDate = $request->get('end_date', now());

        // Order statistics
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::whereIn('status', ['accepted', 'processing'])->count();

        // Customer statistics
        $totalCustomers = User::count();
        $newCustomers = User::whereBetween('created_at', [$startDate, $endDate])->count();

        // Product statistics
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 10)->count();
        $outOfStockProducts = Product::where('stock', '=', 0)->count();

        // Credit statistics
        $pendingCreditApplications = CreditApplication::where('status', 'pending')->count();
        $approvedCreditApplications = CreditApplication::where('status', 'approved')->count();
        $totalCreditLimit = CreditApplication::where('status', 'approved')->sum('approved_limit');
        $usedCreditLimit = CreditApplication::where('status', 'approved')->sum('used_limit');

        // Daily sales chart data
        $dailySales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total_sales'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.total) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Recent orders
        $recentOrders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'statistics' => [
                    'orders' => [
                        'total' => $totalOrders,
                        'pending' => $pendingOrders,
                        'processing' => $processingOrders,
                        'revenue' => $totalRevenue,
                    ],
                    'customers' => [
                        'total' => $totalCustomers,
                        'new' => $newCustomers,
                    ],
                    'products' => [
                        'total' => $totalProducts,
                        'low_stock' => $lowStockProducts,
                        'out_of_stock' => $outOfStockProducts,
                    ],
                    'credit' => [
                        'pending_applications' => $pendingCreditApplications,
                        'approved_applications' => $approvedCreditApplications,
                        'total_limit' => $totalCreditLimit,
                        'used_limit' => $usedCreditLimit,
                    ],
                ],
                'charts' => [
                    'daily_sales' => $dailySales,
                    'top_products' => $topProducts,
                ],
                'recent_orders' => $recentOrders,
            ],
        ]);
    }


}