<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderFood;
use App\Models\Food;
use App\Models\FoodOrder;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    public function order_submit(Request $request)
    {
        $user = Auth::user();
        $restaurant = $user->restaurant;

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->restaurant_id = $restaurant->id;
        // dd($customer);
        // $customer->save();


        $customerOrder = new CustomerOrder();

        // dd($customerOrder);

        $customerOrder->restaurant_id = $restaurant->id;
        $customerOrder->customer_id = $customer->id;
        $customerOrder->ordernumber = random_int(10000000000, 99999999999);
        $customerOrder->total_amount = $request->input('total');
        $customerOrder->table_number = $request->table_number;
        $customerOrder->status = $request->status;

        $customerOrder->save();
        $customerOrder->ordernumber = $customerOrder->ordernumber . $customerOrder->id;
        $customerOrder->update();

        // Retrieve all items from the cart
        $cartItems = Cart::all();

        // Iterate through each item in the cart
        foreach ($cartItems as $cartItem) {
            // Create a new instance of CustomerOrderFood
            $orderFood = new OrderItem();

            // Copy data from cart item to customer order food
            $orderFood->restaurant_id = $restaurant->id;
            $orderFood->order_id = $customerOrder->id;
            $orderFood->food_id = $cartItem->food_id;
            $orderFood->quantity = $cartItem->quantity;
            $orderFood->notes = $cartItem->notes;
            // dd($orderFood);

            //  // Assuming payment information is stored in the request
            // $orderFood->payment_usd = $request->currency === 'USD' ? $request->payment : null;
            // $orderFood->payment_khr = $request->currency === 'KHR' ? $request->payment : null;

            // // Combine selected payment methods into a string
            // $paymentMethods = implode(',', $request->input('payment_method'));
            // $orderFood->payment_method = $paymentMethods;

            // // dd($orderFood);

            // Save the order food item
            $orderFood->save();
        }

        // Optional: You may want to clear the cart after checkout
        Cart::truncate();

        // Redirect or return a response as needed
        return redirect()->route('POS-CustomerOrder.detail', ['orderId' => $customerOrder->id]);
    }
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
