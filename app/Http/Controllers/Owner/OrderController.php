<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\FoodOrder;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function userOrder()
    {

        $data['getOrderUser'] = Order::getUserOrders();

        return view('owner.order.userOrder', $data);
    }


    // public function showUserOrderDetails($orderId)
    // {
    //     $orderDetails = FoodOrder::with(['food', 'order.user', 'order.restaurant', 'order.food'])
    //         ->join('orders', 'food_order.order_id', '=', 'orders.id')
    //         ->join('users', 'orders.user_id', '=', 'users.id')
    //         ->join('foods', 'food_order.food_id', '=', 'foods.id')
    //         ->select(
    //             'users.id as user_id',
    //             'users.first_name',
    //             'users.last_name',
    //             'food_order.*',
    //             'food_order.id',
    //             'orders.restaurant_id',
    //             'foods.*',
    //             'foods.name',
    //             'food_order.quantity',
    //             'food_order.food_id',
    //             DB::raw('SUM(food_order.quantity * foods.price) AS total_price')
    //         )
    //         ->where('food_order.id', $orderId)
    //         ->groupBy('users.id', 'users.first_name', 'users.last_name', 'food_order.id', 'food_order.quantity', 'orders.restaurant_id', 'foods.price')
    //         ->first();

    //     // dd($orderDeetails->toArray());
    //     if (!$orderDetails) {
    //         // Handle the case where the order ID is not found
    //         abort(404, 'Order not found');
    //     }

    //     return view('owner.order.detailOrder', compact('orderDetails'));
    // }
    public function orderDetails($orderId)
    {

        $data['getOrderDetails'] = Order::getOrderDetails($orderId);
        return view('owner.order.detailOrder',$data);
    }






    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);

        return view('owner.order.edit', compact('order'));
    }
}
