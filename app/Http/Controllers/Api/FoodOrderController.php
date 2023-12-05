<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodOrderController extends Controller
{
    public function store(Request $request, $restaurantId)
    {
        // Validate the request
        $this->validate($request, [
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Create a new order for a specific restaurant
        $order = new Order([
            'menu_item_id' => $request->input('menu_item_id'),
            'quantity' => $request->input('quantity'),
            'user_id' => Auth::id(),
            'restaurant_id' => $restaurantId,
        ]);

        $order->save();

        return response()->json(['order' => $order], 201);
    }
}
