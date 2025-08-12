<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CreditApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Display the user's credit applications.
     */
    public function index(Request $request): JsonResponse
    {
        $applications = CreditApplication::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $applications,
        ]);
    }

    /**
     * Create a new credit application.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'requested_amount' => 'required|numeric|min:100000|max:10000000',
        ]);

        $user = $request->user();

        // Check if user already has a pending or approved application
        $existingApplication = CreditApplication::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending or approved credit application',
            ], 422);
        }

        $application = CreditApplication::create([
            'user_id' => $user->id,
            'requested_amount' => $request->requested_amount,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'data' => $application,
            'message' => 'Credit application submitted successfully',
        ], 201);
    }

    /**
     * Display the specified credit application.
     */
    public function show(Request $request, CreditApplication $creditApplication): JsonResponse
    {
        if ($creditApplication->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $creditApplication,
        ]);
    }

    /**
     * Review credit application (admin only).
     */
    public function update(Request $request, CreditApplication $creditApplication): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'approved_limit' => 'required_if:status,approved|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $data = [
            'status' => $request->status,
            'reviewed_at' => now(),
            'notes' => $request->notes,
        ];

        if ($request->status === 'approved') {
            $data['approved_limit'] = $request->approved_limit;
            $data['available_limit'] = $request->approved_limit;
        }

        $creditApplication->update($data);

        return response()->json([
            'success' => true,
            'data' => $creditApplication,
            'message' => 'Credit application reviewed successfully',
        ]);
    }


}