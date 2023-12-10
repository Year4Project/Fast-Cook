<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    public function store(Request $request, $restaurantId)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'table_no' => 'required|integer|min:1',
            'remark' => 'nullable|string',
        ]);

        // Retrieve the authenticated user using JWTAuth
        $user = JWTAuth::parseToken()->authenticate();

        // Create an order associated with the user
        $order = Order::create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurantId,
            'items' => $request->input('items'),
            'quantity' => $request->input('quantity'),
            'table_no' => $request->input('table_no'),
            'remark' => $request->input('remark'),
        ]);

        // Transform the order data for response
        $responseData = [
            'user_id' => $user->id,
            'items' => $order->items, // Use the correct field name 'items'
            'quantity' => $order->quantity,
            'table_no' => $order->table_no,
            'remark' => $order->remark,
        ];

        // Return a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Order food successfully',
            'order' => $responseData,
        ], 201);
    }
}
