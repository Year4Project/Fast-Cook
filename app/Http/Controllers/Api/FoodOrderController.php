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


    // public function getHistoryOrder(Request $request)
    // {
    //     try {
    //         // Authenticate the user using JWT
    //         $user = JWTAuth::parseToken()->authenticate();
    
    //         // Retrieve orders for the authenticated user, ordered by created_at in descending order
    //         $orders = Order::where('user_id', $user->id)
    //                        ->with(['restaurant', 'paymentMethod']) // Include related restaurant and payment method data
    //                        ->orderBy('created_at', 'desc')
    //                        ->paginate(20);
    
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Successfully retrieved order history.',
    //             'data' => $orders
    //         ], 200);
    
    //     } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Token has expired.',
    //         ], 401);
    
    //     } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Token is invalid.',
    //         ], 401);
    
    //     } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Token is absent.',
    //         ], 401);
    
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'An error occurred while retrieving order history.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function getHistoryOrder(Request $request)
{
    try {
        // Authenticate the user using JWT
        $user = JWTAuth::parseToken()->authenticate();

        // Retrieve orders for the authenticated user, ordered by created_at in descending order
        $orders = Order::where('user_id', $user->id)
                       ->with([
                           'restaurant', 
                           'paymentMethod', 
                           'foods' => function($query) {
                               $query->select('foods.id', 'foods.name', 'foods.currency'); // Select necessary fields
                           }
                       ]) // Include related restaurant, payment method, and food data
                       ->orderBy('created_at', 'desc')
                       ->paginate(20);

        return response()->json([
            'status' => true,
            'message' => 'Successfully retrieved order history.',
            'data' => $orders
        ], 200);

    } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Token has expired.',
        ], 401);

    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Token is invalid.',
        ], 401);

    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Token is absent.',
        ], 401);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'An error occurred while retrieving order history.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    

}
