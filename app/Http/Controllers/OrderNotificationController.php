<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderNotificationController extends Controller
{
    public function notifyCustomerOrderAccepted($orderId)
    {
        // Your notification logic here
        // Example: send an email, push notification, SMS, etc.
        
        return response()->json(['success' => true, 'message' => 'Notification sent to customer'], 200);
    }
}
