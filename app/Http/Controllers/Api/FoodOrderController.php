<?php

namespace App\Http\Controllers\Api;

use App\Notifications\NewOrderNotification;
use App\Events\NewOrderPlaced;
use App\Events\OrderPlacedEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tymon\JWTAuth\Facades\JWTAuth;

class FoodOrderController extends Controller
{

    /** This function for user order food from mobile phone
     *  This Route API
     */
    // public function orderFood(Request $request)
    // {
    //     $request->validate([
    //         'items' => 'required|array',
    //         'items.*.food_id' => 'required|exists:foods,id',
    //         'items.*.quantity' => 'required|integer|min:1',
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

    //     $restaurant = Restaurant::findOrFail($request->input('restaurant_id'));


    //     // Assuming $user and $restaurant are defined elsewhere

    //     // Generate a random order number
    //     $ordernumber = random_int(10000000000, 99999999999);

    //     // Create an order associated with the user and restaurant
    //     $order = Order::create([
    //         'user_id' => $user->id,
    //         'ordernumber' => $ordernumber, // corrected assignment
    //         'restaurant_id' => $restaurant->id,
    //         'items' => $request->input('items'),
    //         'table_no' => $request->input('table_no'),
    //         'remark' => $request->input('remark'),
    //         'total_quantity' => $totalQuantity,
    //     ]);


    //     // dd($order);
    //     // Attach food items to the order
    //     $order->foods()->attach($request->input('items'));

    //     // Transform the order data for response
    //     $responseData = [
    //         'user_id' => $user->id,
    //         'ordernumber' => $order->ordernumber,
    //         'items' => $order->items,
    //         'table_no' => $order->table_no,
    //         'restaurant_id' => $order->restaurant_id,
    //         'restaurant_name' => $restaurant->name,
    //         'remark' => $order->remark,
    //         'total_quantity' => $totalQuantity,
    //     ];
    //     // Dispatch the event
    //     event(new OrderPlacedEvent($order, $restaurant->id));

    //     // Return a JSON response
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Order food successfully',
    //         'data' => $responseData,
    //     ], 201);
    // }

    // public function orderFood(Request $request)
    // {
    //     $request->validate([
    //         'items' => 'required|array',
    //         'items.*.food_id' => 'required|exists:foods,id',
    //         'items.*.quantity' => 'required|integer|min:1',
    //         'restaurant_id' => 'required|integer|exists:restaurants,id',
    //         'payment_method.payment_type' => 'required|string',
    //         'payment_method.account_number' => 'required|string',
    //         'payment_method.type' => 'required|string',
    //         'table_no' => 'nullable|integer',
    //         'remark' => 'nullable|string',
    //     ]);

    //     // Retrieve the authenticated user using JWTAuth
    //     $user = JWTAuth::parseToken()->authenticate();

    //     // Calculate total quantity
    //     $totalQuantity = 0;
    //     foreach ($request->input('items', []) as $food) {
    //         $totalQuantity += $food['quantity'];
    //     }

    //     $restaurant = Restaurant::findOrFail($request->input('restaurant_id'));

    //     // Generate a random order number
    //     $ordernumber = random_int(10000000000, 99999999999);

    //     // Create an order associated with the user and restaurant
    //     $order = Order::create([
    //         'user_id' => $user->id,
    //         'ordernumber' => $ordernumber,
    //         'restaurant_id' => $restaurant->id,
    //         'items' => $request->input('items'),
    //         'table_no' => $request->input('table_no'),
    //         'remark' => $request->input('remark'),
    //         'total_quantity' => $totalQuantity,
    //         'payment_method' => $request->input('payment_method'), // Store payment method as JSON
    //     ]);

    //     // Attach food items to the order
    //     $order->foods()->attach($request->input('items'));

    //     // Transform the order data for response
    //     $responseData = [
    //         'user_id' => $user->id,
    //         'ordernumber' => $order->ordernumber,
    //         'items' => $order->items,
    //         'table_no' => $order->table_no,
    //         'restaurant_id' => $order->restaurant_id,
    //         'restaurant_name' => $restaurant->name,
    //         'remark' => $order->remark,
    //         'total_quantity' => $totalQuantity,
    //         'payment_method' => $order->payment_method, // Include payment method in response
    //     ];

    //     // Dispatch the event
    //     event(new OrderPlacedEvent($order, $restaurant->id));

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
            'restaurant_id' => 'required|integer|exists:restaurants,id',
            'payment_method.payment_type' => 'required|string',
            'payment_method.account_number' => 'string|nullable',
            'payment_method.type' => 'string|nullable',
            'table_no' => 'nullable|integer',
            'remark' => 'nullable|string',
        ]);

        // Retrieve the authenticated user using JWTAuth
        $user = JWTAuth::parseToken()->authenticate();

        // Calculate total quantity
        $totalQuantity = 0;
        foreach ($request->input('items', []) as $food) {
            $totalQuantity += $food['quantity'];
        }

        $restaurant = Restaurant::findOrFail($request->input('restaurant_id'));

        // Generate a random order number
        $ordernumber = random_int(10000000000, 99999999999);

        // Store payment method
        $paymentMethod = PaymentMethod::create([
            'payment_type' => $request->input('payment_method.payment_type'),
            'account_number' => $request->input('payment_method.account_number'),
            'type' => $request->input('payment_method.type'),
        ]);

        // Create an order associated with the user and restaurant
        $order = Order::create([
            'user_id' => $user->id,
            'ordernumber' => $ordernumber,
            'restaurant_id' => $restaurant->id,
            'items' => $request->input('items'),
            'table_no' => $request->input('table_no'),
            'remark' => $request->input('remark'),
            'total_quantity' => $totalQuantity,
            'payment_method_id' => $paymentMethod->id,
        ]);

        // Attach food items to the order
        $order->foods()->attach($request->input('items'));

        // Transform the order data for response
        $responseData = [
            'user_id' => $user->id,
            'ordernumber' => $order->ordernumber,
            'items' => $order->items,
            'table_no' => $order->table_no,
            'restaurant_id' => $order->restaurant_id,
            'restaurant_name' => $restaurant->name,
            'remark' => $order->remark,
            'total_quantity' => $totalQuantity,
            'payment_method' => [
                'payment_type' => $paymentMethod->payment_type,
                'account_number' => $paymentMethod->account_number,
                'type' => $paymentMethod->type,
            ],
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

    public function updateStatus(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
        }

        $status = $request->input('status');

        if (!in_array($status, ['accepted', 'rejected'])) {
            return response()->json(['success' => false, 'message' => 'Invalid status.'], 400);
        }

        $order->status = $status;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order status updated.']);
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order status updated successfully.']);
    }
}
