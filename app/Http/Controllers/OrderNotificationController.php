<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
class OrderNotificationController extends Controller
{

   

    public function notifyCustomerOrderAccepted(Request $request, $orderId)
    {
        $user = Auth::user();
        $restaurantId = $user->restaurant->id;
        // Retrieve restaurant ID from the request or your database
        
        // Initialize Pusher with your credentials
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );
    
        // Trigger a notification event on the restaurant's channel
        $pusher->trigger('restaurant.' . $restaurantId, 'order-placed', [
            'orderId' => $orderId,
            'message' => 'Your order has been accepted.',
        ]);
    
        // For demonstration purposes, return a success response
        return response()->json(['success' => true, 'message' => 'Notification sent to customer'], 200);
    }
    
}
