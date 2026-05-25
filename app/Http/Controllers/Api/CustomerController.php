<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function index(): JsonResponse
    {
        $customers = Customer::query()->latest()->get();

        return response()->json([
            "success" => true,
            "message" => "Customers retrieved successfully",
            "data" => $customers,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            "customer_id" => ["required", "string"],
            "name" => ["required", "string"],
            "email" => ["required", "email", "unique:customers,email"],
            "phone" => ["required", "string"],
            "address" => ["nullable", "string"],
            "status" => ["required", "boolean"],
        ]);

        $customer = Customer::query()->create($data);

        return response()->json([
            "success" => true,
            "message" => "Customer created successfully",
            "data" => $customer,
        ], 201);
    }

    public function update(Request $request, int $customer): JsonResponse
    {
        $customer = Customer::query()->find($customer);

        if (!$customer) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Customer not found",
                    "errors" => [],
                ],
                404,
            );
        }

        $data = $request->validate([
            "customer_id" => [
                "sometimes",
                "string",
                "unique:customers,customer_id," . $customer->id,
            ],
            "name" => ["sometimes", "string"],
            "email" => [
                "nullable",
                "email",
                "unique:customers,email," . $customer->id,
            ],
            "phone" => ["nullable", "string"],
            "address" => ["nullable", "string"],
            "status" => ["nullable", "boolean"],
        ]);

        $customer->update($data);

        return response()->json([
            "success" => true,
            "message" => "Customer updated successfully",
            "data" => $customer,
        ]);
    }

    public function show(int $customer): JsonResponse
    {
        $customer = Customer::query()
            ->with('subscriptions.service')
            ->find($customer);

        if (!$customer) {
            return response()->json([
                "success" => false,
                "message" => "Customer not found",
                "errors" => [],
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Customer retrieved successfully",
            "data" => $customer,
        ]);
    }

    public function destroy(int $customer): JsonResponse
    {
        $customer = Customer::query()->find($customer);

        if (!$customer) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Customer not found",
                    "errors" => [],
                ],
                404,
            );
        }

        if ($customer->subscriptions()->exists()) {
            return response()->json(
                [
                    "success" => false,
                    "message" =>
                        "Customer cannot be deleted because it has subscriptions",
                    "errors" => [],
                ],
                422,
            );
        }

        $customer->delete();

        return response()->json([
            "success" => true,
            "message" => "Customer deleted successfully",
            "data" => null,
        ]);
    }

    public function activate(int $customer): JsonResponse
    {
        $customer = Customer::query()->find($customer);

        if (!$customer) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Customer not found",
                    "errors" => [],
                ],
                404,
            );
        }

        $customer->update(["status" => true]);

        return response()->json([
            "success" => true,
            "message" => "Customer activated successfully",
            "data" => $customer,
        ]);
    }

    public function deactivate(int $customer): JsonResponse
    {
        $customer = Customer::query()->find($customer);

        if (!$customer) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Customer not found",
                    "errors" => [],
                ],
                404,
            );
        }

        $customer->update(["status" => false]);

        return response()->json([
            "success" => true,
            "message" => "Customer deactivated successfully",
            "data" => $customer,
        ]);
    }
}