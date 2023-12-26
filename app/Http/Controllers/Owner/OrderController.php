<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\FoodOrder;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function userOrder()
    {
        // Latest Orders Subquery
        $latestOrdersSubquery = DB::table('food_order')
            ->select(
                'users.id as user_id',
                'orders.restaurant_id',
                DB::raw('MAX(food_order.id) as latest_order_id')
            )
            ->join('orders', 'food_order.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->groupBy('users.id', 'orders.restaurant_id');

        // Main Eloquent Query
        $foodOrders = FoodOrder::with(['food', 'order.user', 'order.restaurant'])
            ->joinSub($latestOrdersSubquery, 'latest_orders', function ($join) {
                $join->on('food_order.id', '=', 'latest_orders.latest_order_id');
            })
            ->join('orders', 'food_order.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('foods', 'food_order.food_id', '=', 'foods.id')
            ->select(
                'users.id as user_id',
                'users.first_name',
                'users.last_name',
                'food_order.*',
                'orders.restaurant_id',
                'foods.oPrice',
                'foods.dPrice',
                DB::raw('SUM(food_order.quantity) as total_quantity'),
                DB::raw('SUM(food_order.quantity * (foods.oPrice - foods.dPrice)) as price_discound') // Calculate total price
            )
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'food_order.id', 'orders.restaurant_id')
            ->orderBy('orders.id', 'DESC')
            ->paginate(10);

        return view('owner.order.userOrder', compact('foodOrders'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function listFoodUser($id)
    {

        $data['getOrderUser'] = Order::getOrderUser($id);
        $data['header_title'] = 'Get Order';

        return view('owner.order.listFoodUser', $data);
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
