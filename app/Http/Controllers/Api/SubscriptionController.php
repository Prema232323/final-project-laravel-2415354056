<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Subscription::with(['customer', 'service'])->latest()->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,trial,isolir,dismantle',
        ]);

        $subscription = Subscription::create($data);

        return response()->json($subscription, 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(
            Subscription::with(['customer', 'service'])->findOrFail($id)
        );
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->update($request->all());

        return response()->json($subscription);
    }

    public function destroy(string $id): JsonResponse
    {
        Subscription::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Subscription deleted successfully'
        ]);
    }
}