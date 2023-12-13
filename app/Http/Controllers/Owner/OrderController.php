<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
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
    public function userOrder($restaurantId)
    {
      
        $data['getUserOrder'] = FoodOrder::getUserOrder();

        return view('owner.order.userOrder',$data);
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
