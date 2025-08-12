<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class InventoryReportController extends Controller
{
    /**
     * Get inventory report.
     */
    public function index(): JsonResponse
    {
        $products = Product::with('category')
            ->select([
                'id', 'name', 'stock', 'price', 'category_id',
                DB::raw('(stock * price) as inventory_value')
            ])
            ->orderBy('stock', 'asc')
            ->get();

        $totalValue = $products->sum('inventory_value');
        $lowStockCount = $products->where('stock', '<=', 10)->count();
        $outOfStockCount = $products->where('stock', '=', 0)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products,
                'summary' => [
                    'total_products' => $products->count(),
                    'total_value' => $totalValue,
                    'low_stock_count' => $lowStockCount,
                    'out_of_stock_count' => $outOfStockCount,
                ],
            ],
        ]);
    }
}