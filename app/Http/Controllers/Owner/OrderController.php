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
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\OrderSubmitRequest;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *in this function for pos request customer order in restaruant 
     * @return \Illuminate\Http\Response
     */
    public function order_submit(OrderSubmitRequest $request)
    {
        // If validation passes, continue with the order submission process
    
        $user = Auth::user();
        $restaurant = $user->restaurant;
    
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->restaurant_id = $restaurant->id;
        $customer->save();
    
        $customerOrder = new CustomerOrder();
        $customerOrder->restaurant_id = $restaurant->id;
        $customerOrder->customer_id = $customer->id;
        $customerOrder->ordernumber = random_int(10000000000, 99999999999);
        $customerOrder->total_amount = $request->input('total');
        $customerOrder->table_number = random_int(1000, 9999);
        $customerOrder->status = 'completed';
        $customerOrder->save();
    
        $payment = new Payment();
        $payment->restaurant_id = $restaurant->id;
        $payment->customer_order_id = $customerOrder->id;
        $payment->amount = $request->input('payment_amount');
        $payment->currency = $request->input('currency');
        $payment->payment_method = implode(',', $request->input('payment_method')); // Combine selected payment methods into a string
        $payment->save();
    
        $cartItems = Cart::where('restaurant_id', $restaurant->id)->get();


        // dd($cartItems);
    
        foreach ($cartItems as $cartItem) {
            $orderFood = new OrderItem();
            $orderFood->restaurant_id = $restaurant->id;
            $orderFood->customer_order_id = $customerOrder->id;
            $orderFood->food_id = $cartItem->food_id;
            $orderFood->quantity = $cartItem->quantity;
            $orderFood->save();
        }
    
        Cart::where('restaurant_id', $restaurant->id)->delete();
    
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

        // dd($data);
        
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
        $data['getCustomerOrder'] = Customer::getCustomerOrders($orderId);
        // dd($data);
     
        return view('owner.pos.detailOrder', $data);
    }
    public function printRecipe($orderId)
{
    // Retrieve the customer order details using getCustomerOrders function
    $customerOrder = Customer::getCustomerOrders($orderId);

    // dd($customerOrder);

    // Check if the retrieved customer order is not null
    if ($customerOrder !== null) {
        // Pass the retrieved customer order to the view for rendering
        return view('owner.pos.printRecipe', ['customerOrder' => $customerOrder]);
    } else {
        // Handle the case where the customer order is null
        return "Customer order not found.";
    }
}

public function printRecipeAPI($orderId)
{
    $data['getOrderDetails'] = Order::getOrderDetails($orderId);
   

    // dd($data);

    // Check if the retrieved customer order is not null
    // if ($data !== null) {
        // Pass the retrieved customer order to the view for rendering
        return view('owner.order.printRecipe',  $data);
    // } else {
        // Handle the case where the customer order is null
        // return "Customer order not found.";
    // }
}

    
}
