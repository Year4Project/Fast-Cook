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
            'user_id' => 'required',
            'food_id' => 'required',
            'quantity' => 'required',
            'remark' => 'required|string|max:191',
            'table_note' => 'required',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $order = Order::create([
                'user_id' => $request->user_id,
                'food_id' => $request->food_id,
                'quantity' => $request->quantity,
                'remark' => $request->remark,
                'table_note'=> $request->table_note,
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