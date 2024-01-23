<?php

namespace App\Http\Controllers\Api;

use App\Notifications\NewOrderNotification;
use App\Events\NewOrderPlaced;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\FoodOrderRequest;

class FoodOrderController extends Controller
{
    public function orderFood(FoodOrderRequest $request)
    {
        try {
            // Retrieve the authenticated user using JWTAuth
            $user = JWTAuth::parseToken()->authenticate();

            // Calculate total quantity
            $totalQuantity = 0;
            $foodOrder = [];

            foreach ($request->input('items', []) as $food) {
                $foodModel = Food::find($food['food_id']);
                $foodOrder[] = [
                    'food_id' => $foodModel->id,
                    'quantity' => $food['quantity'],
                ];
                $totalQuantity += $food['quantity'];
            }

            // Create an order associated with the user
            $order = Order::create([
                'user_id' => $user->id,
                'restaurant_id' => $request->input('restaurant_id'),
                'table_no' => $request->input('table_no'),
                'remark' => $request->input('remark'),
                'total_quantity' => $totalQuantity,
            ]);

            // Attach food items to the order
            $order->foods()->attach($foodOrder);

            // Dispatch the notification
            $user->notify(new NewOrderNotification($order));

            // Dispatch the event with the created order
            event(new NewOrderPlaced($order));

            // Transform the order data for response
            $responseData = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name, // Include other user details as needed
                ],
                'items' => $order->items,
                'table_no' => $order->table_no,
                'restaurant_id' => $order->restaurant_id,
                'remark' => $order->remark,
                'total_quantity' => $totalQuantity,
            ];

            // Return a JSON response
            return response()->json([
                'status' => true,
                'message' => 'Order food successfully',
                'data' => $responseData,
            ], 201);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to order food',
            ], 500);
        }
    }


    // Get all images
    public function getAllFood()
    {
        try {
            // ... (existing code)
            $foodData = Food::all();
            // Return a JSON response
            return response()->json([
                'status' => true,
                'data' => $foodData,
            ]);
        } catch (\Exception $e) {

            // Return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch food items',
            ], 500);
        }
    }
}
