<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderFood;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    public function foodOrder(Request $request)
    {
        // Validate the request data
        $request->validate([
            'user_id' => 'required',
            'restaurant_id' => 'required',
            'food_id' => 'required',
            'table_no' => 'required',
            'quantity' => 'required|min:1',
        ]);

        $user = JWTAuth::user();
        // Create a new order
        $order = Order::create($request->all());

        // Send notification to the restaurant owner
    //    Notification::send($order, new OrderNotification($request->name));

        // You can add additional logic here, like sending notifications or processing the order

        return response()->json([
            'status' => 200,
            'message' => 'Order placed successfully',
            'data' => ['order' => $order,'userOrder' => $user]
        ]);
    }
}
