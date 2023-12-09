<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RestaurantControllerApi extends Controller
{
    // public function checkKey($apikey){
    //     $keys = array('12345678','987654321');
    //     if(in_array($apikey, $keys)){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    public function getListFood(Request $r, $id){
       
        $food = DB::table('food')->where("restaurant_id", $id );
        
        if($r->keyword){
            $food = $food->where('name', 'LIKE', "%$r->keyword%")
                        ->orWhere('dPrice', $r->keyword);
        }
        $food = $food->get();

        if($food->count() > 0){

            return response()->json([
                'status' => 200,
                'foods' => $food
            ],200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    public function orderConfirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'food_id' => 'required',
            'quantity' => 'required',
            'remark' => 'required|string|max:191',
            'table_no' => 'required',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $order = Order::create([
                'user_id' => Auth::id(),
                'food_id' => $request->food_id,
                'quantity' => $request->quantity,
                'remark' => $request->remark,
                'table_no'=> $request->table_no,
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