<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CreditApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreditStatusController extends Controller
{
    /**
     * Get current credit status for user.
     */
    public function index(Request $request): JsonResponse
    {
        $application = CreditApplication::where('user_id', $request->user()->id)
            ->where('status', 'approved')
            ->first();

        if (!$application) {
            return response()->json([
                'success' => true,
                'data' => [
                    'has_credit' => false,
                    'approved_limit' => 0,
                    'used_limit' => 0,
                    'available_limit' => 0,
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'has_credit' => true,
                'approved_limit' => $application->approved_limit,
                'used_limit' => $application->used_limit,
                'available_limit' => $application->available_limit,
            ],
        ]);
    }
}