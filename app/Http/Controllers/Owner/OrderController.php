<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderFood;
use App\Models\Food;
use App\Models\FoodOrder;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    /**
     * display the order form mobile application using api routes
     */
    public function userOrder()
    {

        $data['getOrderUser'] = Order::getUserOrders();

        return view('owner.order.userOrder', $data);
    }


    /**
     * display all order form mobile application using api routes
     */
    public function orderDetails($orderId)
    {

        $data['getOrderDetails'] = Order::getOrderDetails($orderId);
        return view('owner.order.detailOrder', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);

        return view('owner.order.edit', compact('order'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function customerOrderDetail($orderId)
    {

        $data['customerOrderFood'] = CustomerOrderFood::getCustomerOrders($orderId);

        // Store the data in the session
        Session::put('customer_order_food', $data['customerOrderFood']);

        // dd($data['customerOrderFood']);

        return view('owner.pos.detailOrder', $data);
    }

    public function printRecipe()
    {
        // Retrieve the currently authenticated user
        $user = Auth::user();
    
        // Check if the user is authenticated and has a restaurant associated with them
        if ($user && $user->restaurant) {
            // Retrieve the restaurant
            $restaurant = $user->restaurant;
    
            // Retrieve the data from the session
            $data['customerOrderFood'] = Session::get('customer_order_food');
    
            // Check if $customerOrderFood is null
            if ($data['customerOrderFood'] !== null) {
                // Add the restaurant to the data array
                $data['restaurant'] = $restaurant;
    
                // You can now use $customerOrderFood and $restaurant to print recipes or do any other processing
                return view('owner.pos.printRecipe', $data);
            } else {
                // Handle the case where $customerOrderFood is null
                return "No data available for printing recipe.";
            }
        } else {
            // Handle the case where the user is not authenticated or has no associated restaurant
            return "User is not authenticated or has no associated restaurant.";
        }
    }
    
}
