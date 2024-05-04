<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderFood;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderFood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('query');
        $category_id = $request->input('category_id');

        $foods = $user->restaurant->foods();

        // Filter by search query if provided
        if ($query) {
            $foods->where('name', 'like', '%' . $query . '%');
        }

        // Only apply category filter if a category is selected
        if ($category_id) {
            $foods->where('category_id', $category_id);
        }

        $data['restaurant'] = $foods->get();
        $data['addToCart'] = $user->restaurant->cart()->get();
        $data['categories'] = $user->restaurant->category()->get();
        $data['header_title'] = 'List Food';

        return view('owner.cart.index', $data);
    }


    public function addItemToCart(Request $request)
    {
        $user = Auth::user();
        $restaurant = $user->restaurant->id;

        // Check if the item already exists in the cart
        $existingItem = Cart::where('restaurant_id', $restaurant)
            ->where('name', $request->name)
            ->first();

        if ($existingItem) {
            // If item exists, update its quantity
            $existingItem->quantity += $request->quantity;
            $existingItem->total = $existingItem->price * $existingItem->quantity;
            $existingItem->save();
        } else {
            // If item doesn't exist, create a new cart item
            $addItem = new Cart();
            $addItem->restaurant_id = $restaurant;
            $addItem->name = $request->name;
            $addItem->price = $request->price;
            $addItem->image_url = $request->image_url;
            $addItem->food_id = $request->food_id;
            $addItem->quantity = $request->quantity;
            $addItem->description = $request->description;
            $addItem->total = $request->price * $request->quantity;
            $addItem->save();
        }

        return back();
    }

    public function updateCartItemQuantity(Request $request)
    {
        $user = Auth::user();
        $restaurant = $user->restaurant->id;

        // Retrieve the item from the cart
        $cartItem = Cart::where('restaurant_id', $restaurant)
            ->where('id', $request->cart_item_id)
            ->first();

        if ($cartItem) {
            // Update the quantity and total price of the item
            $newQuantity = intval($request->quantity);

            // Ensure quantity is at least 1
            if ($newQuantity < 1) {
                $newQuantity = 1;
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->total = $cartItem->price * $newQuantity;
            $cartItem->save();

            return back()->with('success', 'Cart item quantity updated successfully.');
        } else {
            return back()->with('error', 'Cart item not found.');
        }
    }


   
    public function deleteItem(Request $request)
    {
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

    public function customerOrder(Request $request)
    {
        $user = Auth::user();
        $data['orderCustomer'] = CustomerOrder::where('restaurant_id', $user->restaurant->id)->orderBy('id', 'desc')->get();

        // dd($data);
        // $customerOrder = $user->restaurant->customerOrder->get();
        return view('owner.cart.customerOrder', $data);
    }

    public function clearCart()
    {
        $user = Auth::user();
        $restaurant = $user->restaurant->id;

        // Delete all cart items for the current user
        Cart::where('restaurant_id', $restaurant)->delete();

        // You may return a response or redirect the user as needed
        return back()->with(['message' => 'Cart cleared successfully']);
    }
}
