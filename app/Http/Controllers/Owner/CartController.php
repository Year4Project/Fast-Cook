<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
public function index(){
    $user = Auth::user();
    $data['restaurant'] = $user->restaurant->foods()->get();
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
}
