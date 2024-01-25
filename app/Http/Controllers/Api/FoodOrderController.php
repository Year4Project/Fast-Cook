<?php

namespace App\Http\Controllers\Api;

use App\Notifications\NewOrderNotification;
use App\Events\NewOrderPlaced;
use App\Events\OrderPlacedEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use Tymon\JWTAuth\Facades\JWTAuth;

class FoodOrderController extends Controller
{
    // public function orderFood(Request $request)
    // {
    //     $request->validate([
    //         'items' => 'required|array',
    //         'items.*.food_id' => 'required|exists:foods,id',
    //         'items.*.quantity' => 'required|integer|min:1',
    //         'table_no' => 'required|integer|min:1',
    //         'restaurant_id' => 'required|integer|min:1',
    //         'remark' => 'nullable|string',
    //     ]);

    //     // Retrieve the authenticated user using JWTAuth
    //     $user = JWTAuth::parseToken()->authenticate();

    //     // Calculate total quantity
    //     $totalQuantity = 0;
    //     // Capture food_id and quantity for each selected food
    //     $foodOrder = [];
    //     foreach ($request->input('items', []) as $food) {
    //         $foodModel = Food::find($food['food_id']);
    //         $foodOrder[] = [
    //             'food_id' => $foodModel->id,
    //             'quantity' => $food['quantity'],
    //         ];
    //         $totalQuantity += $food['quantity'];
    //     }

    //     // Create an order associated with the user
    //     $order = Order::create([
    //         'user_id' => $user->id,
    //         'restaurant_id' => $request->input('restaurant_id'),
    //         'items' => $request->input('items'),
    //         'table_no' => $request->input('table_no'),
    //         'remark' => $request->input('remark'),
    //         'total_quantity' => $totalQuantity,
    //     ]);

    //     // dd($order);


    //     // Attach food items to the order
    //     $order->foods()->attach($request->input('items'));

    //     event(new NewOrderPlaced($order));

    //     // Dispatch the event with the created order
    //     event(new NewOrderPlaced('New order has been placed!'));

    //     // Transform the order data for response
    //     $responseData = [
    //         'user_id' => $user->id,
    //         'items' => $order->items,
    //         'table_no' => $order->table_no,
    //         'restaurant_id' => $order->restaurant_id,
    //         'remark' => $order->remark,
    //         'total_quantity' => $totalQuantity,
    //     ];

    //     // Return a JSON response
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Order food successfully',
    //         'data' => $responseData,
    //     ], 201);
    // }

    public function orderFood(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
            'table_no' => 'required|integer|min:1',
            'restaurant_id' => 'required|integer|min:1',
            'remark' => 'nullable|string',
        ]);

        // Retrieve the authenticated user using JWTAuth
        $user = JWTAuth::parseToken()->authenticate();

        // Calculate total quantity
        $totalQuantity = 0;
        // Capture food_id and quantity for each selected food
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
            'items' => $request->input('items'),
            'table_no' => $request->input('table_no'),
            'remark' => $request->input('remark'),
            'total_quantity' => $totalQuantity,
        ]);

        // dd($order);
        // Attach food items to the order
        $order->foods()->attach($request->input('items'));

        // Transform the order data for response
        $responseData = [
            'user_id' => $user->id,
            'items' => $order->items,
            'table_no' => $order->table_no,
            'restaurant_id' => $order->restaurant_id,
            'remark' => $order->remark,
            'total_quantity' => $totalQuantity,
        ];

        // Dispatch the event
    event(new OrderPlacedEvent($order));

        // Return a JSON response
        return response()->json([
            'status' => true,
            'message' => 'Order food successfully',
            'data' => $responseData,
        ], 201);
    }


    // Get all images
    // public function getAllFood()
    // {
    //     try {
    //         $foodData = Food::all();
    //         // Return a JSON response
    //         return response()->json([
    //             'status' => true,
    //             'data' => $foodData,
    //         ]);
    //     } catch (\Exception $e) {
    //         // Return an error response
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Failed to fetch food items',
    //         ], 500);
    //     }
    // }
}
