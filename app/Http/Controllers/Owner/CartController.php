<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
public function index(){
    $user = Auth::user();
    $data['restaurant'] = $user->restaurant->foods()->get();
    $data['addToCart'] = $user->restaurant->cart()->get();
    $data['header_title'] = 'List Food';
    return view('owner.cart.index',$data);
}

public function addItemToCart(Request $request){
    $user = Auth::user();
    $restaurant = $user->restaurant->id;
    $addItem = new Cart();

    // dd($addItem);
    $addItem->restaurant_id = $restaurant;
    $addItem->name = $request->name;
    $addItem->price = $request->price;
    $addItem->quantity = $request->quantity;
    $addItem->save();

    return back();
}

public function deleteItem(Request $request){
    $user = Auth::user();
    $restaurant_id = $user->restaurant->id;

    // Find the item in the cart by its ID
    $deleteItem = Cart::findOrFail($request->id);

    // Check if the item belongs to the restaurant owned by the authenticated user
    if ($deleteItem->restaurant_id === $restaurant_id) {
        // If it belongs to the restaurant, delete the item
        $deleteItem->delete();
    } else {
        // If it does not belong to the restaurant, handle the error accordingly
        // For example, you can throw an exception or return a response indicating the error.
        return response()->json(['error' => 'Unauthorized action.']);
    }

    return back();
}

public function checkout(Request $request){

    // Validate request data
    $request->validate([
        'items' => 'required|array', // Add more validation rules as needed
        // Other validation rules...
    ]);

    $user = Auth::user();
    $restaurant = $user->restaurant->id;

    // Calculate total quantity
    $totalQuantity = 0;
    // Capture food_id and quantity for each selected food
    $foodOrder = [];
    foreach ($request->input('items', []) as $food) {
        $foodModel = Food::find($food['food_id']);
        $foodOrder[] = [
            'food_id' => $foodModel->id,
            'quantity' => $food['quantity'],
        ];
        $totalQuantity += $food['quantity'];
    }

    // Create an order associated with the user
    $order = Order::create([
        'restaurant_id' == $restaurant,
        'items' => json_encode($request->input('items')),
        'remark' => $request->input('remark'),
        'total_quantity' => $totalQuantity,
    ]);

    // dd($order);
    // Attach food items to the order
    $order->foods()->attach($request->input('items'));

    $order->save();

    return back();
}

public function customerOrder(Request $request){

    return view('owner.cart.customerOrder');
}



// Order

public function clearCart()
{
    // Clear the cart items
    Cart::truncate(); // This will delete all items from the cart table

    // Redirect back or wherever you need to go after clearing the cart
    return redirect()->back()->with('success', 'Cart cleared successfully');
}
}
