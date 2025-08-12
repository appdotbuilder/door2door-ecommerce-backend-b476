<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    /**
     * Get sales report.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'group_by' => 'in:day,week,month',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $groupBy = $request->get('group_by', 'day');

        $dateFormat = match($groupBy) {
            'week' => 'YYYY-WW',
            'month' => 'YYYY-MM',
            default => 'YYYY-MM-DD'
        };

        $sales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->select(
                DB::raw("TO_CHAR(created_at, '{$dateFormat}') as period"),
                DB::raw('SUM(total) as total_sales'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('AVG(total) as average_order_value')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sales,
        ]);
    }
}