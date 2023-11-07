<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
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

        // $orders = Order::with('menus')->get();
        // $menus = Menu::with('orders')->get();

        $orders = DB::table('orders')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('menus','menus.id', '=', 'orders.food_id')
                ->get();

        return view('owner.order.userOrder', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function listFoodUser()
    {
        $orders = DB::table('orders')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('menus','menus.id', '=', 'orders.food_id')
                ->get();

        return view('owner.order.listFoodUser',['orders' => $orders]);
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
        $order = DB::table('orders')
                ->join('users','users.id','=','orders.user_id')
                ->join('menus','menus.id','=','orders.food_id')
                ->get();
        
        $user = DB::table('users')
                ->get();

        $menu = DB::table('menus')
                ->get();
        $order = Order::find(request()->id);
        
        return view('owner.order.edit', ['order' => $order,'$user' => $user, 'menu' => $menu]);
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
