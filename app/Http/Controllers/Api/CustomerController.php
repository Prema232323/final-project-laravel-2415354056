<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Customer::latest()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_id' => 'required|unique:customers',
            'name' => 'required|string',
            'email' => 'nullable|email|unique:customers',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'boolean'
        ]);

        $customer = Customer::create($data);

        return response()->json($customer, 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(Customer::findOrFail($id));
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);

        $customer->update($request->all());

        return response()->json($customer);
    }

    public function destroy(string $id): JsonResponse
    {
        Customer::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Customer deleted successfully'
        ]);
    }
}