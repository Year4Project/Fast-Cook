<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\FoodOrder;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function userOrder()
    {
    
        $restaurantId = session('restaurantId');
    // Subquery to get the latest order for each user
    $latestOrdersSubquery = DB::table('food_order')
        ->select(
            'users.id as user_id',
            'orders.restaurant_id',
            DB::raw('MAX(food_order.id) as latest_order_id')
        )
        ->join('orders', 'food_order.order_id', '=', 'orders.id')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->groupBy('users.id', 'orders.restaurant_id');

    // Your main Eloquent query
    $foodOrders = FoodOrder::with(['food', 'order.user', 'order.restaurant'])
        ->joinSub($latestOrdersSubquery, 'latest_orders', function ($join) {
            $join->on('food_order.id', '=', 'latest_orders.latest_order_id');
        })
        ->join('orders', 'food_order.order_id', '=', 'orders.id')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->select(
            'users.id as user_id',
            'users.first_name',
            'users.last_name',
            'food_order.*',
            'orders.restaurant_id'
        )
        ->orderBy('orders.restaurant_id')
        ->paginate(10);

  
        return view('owner.order.userOrder',compact('foodOrders'));
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);

        return view('owner.order.edit',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
