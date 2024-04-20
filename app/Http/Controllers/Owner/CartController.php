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


    public function order_submit(Request $request)
    {
        $user = Auth::user();
        $restaurant = $user->restaurant;

        $data = new CustomerOrder();
        $data->restaurant_id = $restaurant->id;
        $data->ordernumber = random_int(10000000000, 99999999999);
        $data->total = $request->input('total');
        $data->customername = $request->customername;
        $data->customerphone = $request->customerphone;
        $data->save();
        $data->ordernumber = $data->ordernumber . $data->id;
        $data->update();

        // Retrieve all items from the cart
        $cartItems = Cart::all();

        // Iterate through each item in the cart
        foreach ($cartItems as $cartItem) {
            // Create a new instance of CustomerOrderFood
            $orderFood = new CustomerOrderFood();

            // Copy data from cart item to customer order food
            $orderFood->restaurant_id = $restaurant->id;
            $orderFood->order_id = $data->id;
            $orderFood->name = $cartItem->name;
            $orderFood->price = $cartItem->price;
            $orderFood->image = $cartItem->image_url;
            $orderFood->quantity = $cartItem->quantity;
            $orderFood->description = $cartItem->description;
            $orderFood->total = $cartItem->price * $cartItem->quantity;

            // Save the order food item
            $orderFood->save();
        }

        // Optional: You may want to clear the cart after checkout
        Cart::truncate();

        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Checkout successful!');
    }

    // public function decrementQuantity(int $cartId){
    //     $cartData = Cart::where('id',$cartId)->where('user_id', auth()->user()->id)->first();
    //     if($cartData){
    //         $cartData->decrement('quantity');
    //         $this->dispatchBrowserEvent('message', [
    //             'text' => 'Quantity Updated',
    //             'type' => 'success',
    //             'status' => 200
    //         ]);
    //     }else{
    //         $this->dispatchBrowserEvent('message', [
    //             'text' => 'Something Went Wrong!',
    //             'type' => 'error',
    //             'status' => 404
    //         ]);
    //     }
    // }   
    // public function incrementQuantity(int $cartId){
    //     $cartData = Cart::where('id',$cartId)->where('user_id', auth()->user()->id)->first();
    //     if($cartData){
    //         $cartData->increment('quantity');
    //         $this->dispatchBrowserEvent('message', [
    //             'text' => 'Quantity Updated',
    //             'type' => 'success',
    //             'status' => 200
    //         ]);
    //     }else{
    //         $this->dispatchBrowserEvent('message', [
    //             'text' => 'Something Went Wrong!',
    //             'type' => 'error',
    //             'status' => 404
    //         ]);
    //     }
    // }


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


    // public function checkout(Request $request){

    //     // Validate request data
    //     $request->validate([
    //         'items' => 'required|array', // Add more validation rules as needed
    //         // Other validation rules...
    //     ]);

    //     $user = Auth::user();
    //     $restaurant = $user->restaurant->id;

    //     // Calculate total quantity
    //     $totalQuantity = 0;
    //     // Capture food_id and quantity for each selected food
    //     $foodOrder = [];
    //     foreach ($request->input('items', []) as $food) {
    //         $foodModel = Food::find($food['food_id']);
    //         $foodOrder[] = [
    //             'food_id' => $foodModel->id,
    //             'quantity' => $food['quantity'],
    //         ];
    //         $totalQuantity += $food['quantity'];
    //     }

    //     // Create an order associated with the user
    //     $order = Order::create([
    //         'restaurant_id' == $restaurant,
    //         'items' => json_encode($request->input('items')),
    //         'remark' => $request->input('remark'),
    //         'total_quantity' => $totalQuantity,
    //     ]);

    //     // dd($order);
    //     // Attach food items to the order
    //     $order->foods()->attach($request->input('items'));

    //     $order->save();

    //     return back();
    // }


    // public function checkout(Request $request)
    // {

    //     $user = Auth::user();
    //     $restaurant = $user->restaurant->id;

    //     // Validate the request data
    //     $request->validate([
    //         'items' => 'required|array',
    //         'items.*.food_id' => 'required|exists:foods,id',
    //         'items.*.quantity' => 'required|integer|min:1',
    //         'table_no' => 'required|integer|min:1',
    //         'remark' => 'nullable|string',
    //         'total_quantity' => 'required|integer|min:1', // Add validation for total_quantity if applicable
    //     ]);


    //     // Create a new Order instance
    //     $order = new Order();

    //     // Assign values to the Order attributes
    //     $order->user_id = $user->id;
    //     $order->restaurant_id = $restaurant;
    //     $order->items = $request->input('items');
    //     $order->table_no = $request->input('table_no');
    //     $order->remark = $request->input('remark');
    //     // $order->total_quantity = $request->input('total_quantity'); // Uncomment if you have a total_quantity field in your form

    //     // Save the Order instance to the database
    //     dd($order);
    //     $order->save();

    //     // Attach food items to the order
    //     foreach ($request->input('items') as $item) {
    //         $order->foods()->attach($item['food_id'], ['quantity' => $item['quantity']]);
    //     }

    //     return redirect()->back()->with('success', 'Order placed successfully!');
    // }


    public function customerOrder(Request $request)
    {
        $user = Auth::user();
        $data['orderCustomer'] = CustomerOrder::where('restaurant_id', $user->restaurant->id)->get();

        // dd($data);
        // $customerOrder = $user->restaurant->customerOrder->get();
        return view('owner.cart.customerOrder', $data);
    }



    // Order

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
