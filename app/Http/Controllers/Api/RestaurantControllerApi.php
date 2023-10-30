<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantControllerApi extends Controller
{
    public function getListFood(){
        $menu = Menu::all();
        if($menu->count() > 0){

            return response()->json([
                'status' => 200,
                'menus' => $menu
            ],200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    public function orderConfirm(Request $request){
        $validator = Validator::make($request->all(), [
            'foodname' => 'required|string|max:191',
            'price' => 'required|string|max:191',
            'quantity' => 'required|string|max:191',
            'tablenote' => 'required',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $order = Order::create([
                'foodname' => $request->foodname,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'tablenote' => $request->tablenote,
            ]);

            if($order){

                return response()->json([
                    'status' => 200,
                    'Orders' => "Order Created Successfully"
                ],200);
            }else{

                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong'
                ], 500);
            }
        }
    }

    public function showOrder($id){
        $order = Order::find($id);
        if($order){
            return response()->json([
                'status' => 200,
                'orders' => $order
            ], 200);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'No Such Order Found'
            ], 404);
        }
    }
}