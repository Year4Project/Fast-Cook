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

        // dd($data['customerOrderFood']);

        return view('owner.pos.detailOrder', $data);
    }


    public function printRecipe()
    {

        return view('owner.pos.printRecipe');
    }
}
