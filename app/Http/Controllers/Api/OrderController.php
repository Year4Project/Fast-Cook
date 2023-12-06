<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function foodOrder(Request $request)
    {
        try {
            $validateOrder = Validator::make($request->all(), 
            [
                'user_id' => 'required',
            ]);

            if($validateOrder->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateOrder->errors()
                ], 401);
            }

            if(!Order::attempt($request->only(['user_id']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            // $order = User::where('user_id', $request->id)->first();
            $restaurantId = Auth::user()->id;
            $order = Order::create([
                'restaurant_id' => $restaurantId->id,
                'user_id' => $request->user_id,
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

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
