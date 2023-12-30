<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;

class FoodOrderController extends Controller
{
    public function store(Request $request, $restaurantId)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.food_id' => 'required|exists:foods,id',
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


        // Capture food_id and quantity for each selected food
        $foodOrder = [];
        foreach ($request->input('items', []) as $food) {
            $foodModel = Food::find($food['food_id']);
            $foodOrder[] = [
                'food_id' => $foodModel->id,
                'quantity' => $food['quantity'],
            ];
        }

        // Attach food items to the order
        $order->foods()->attach($request->input('items'));


        // Transform the order data for response
        $responseData = [
            'user_id' => $user->id,
            'items' => $order->items,
            'quantity' => $order->quantity,
            'table_no' => $order->table_no,
            'remark' => $order->remark,
        ];

        // Dispatch the OrderCreated event
        // In your controller
        // event(new OrderCreated($responseData));

        // Return a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Order food successfully',
            'order' => $responseData,
        ], 201);
    }

    // Get all images
    public function getAllFood()
    {
        // Retrieve all food items from the database
        $foods = Food::all();

    

        // Return a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $foods,
        ]);
    }

}
