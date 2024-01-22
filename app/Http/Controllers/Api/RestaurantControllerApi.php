<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RestaurantControllerApi extends Controller
{
    public function getAllFood(Request $r)
    {
        $user = JWTAuth::user();

        $food = Food::query();

        // Add join with the restaurant table
        $food->join('restaurants', 'foods.restaurant_id', '=', 'restaurants.id');

        // Select the columns you want
        $food->select('foods.*', 'restaurants.name as restaurant_name');

        // for searching
        if ($r->keyword) {
            $food->where('foods.name', 'LIKE', "%$r->keyword%")
                ->orWhere('foods.dPrice', $r->keyword)
                ->orWhere('restaurants.name', 'LIKE', "%$r->keyword%");
        }

        $food = $food->get();

        if ($food->count() > 0) {
            return response()->json([
                'status' => true,
                'message' => "Successfully list food",
                'data' => $food,
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    public function getListFood(Request $r, $id)
    {

        $user = JWTAuth::user();

        $food = DB::table('foods')->where("restaurant_id", $id);

        if ($r->keyword) {
            $food = $food->where('name', 'LIKE', "%$r->keyword%")
                ->orWhere('dPrice', $r->keyword);
        }
        $food = $food->get();

        if ($food->count() > 0) {

            return response()->json([
                'status' => true,
                'message' => "Successfully list food",
                'data' => $food,
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    // public function orderConfirm(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'required',
    //         'food_id' => 'required',
    //         'quantity' => 'required',
    //         'remark' => 'required|string|max:191',
    //         'table_no' => 'required',
    //     ]);

    //     // Get the authenticated user
    //     $user = JWTAuth::parseToken()->authenticate();

    //     if ($validator->fails()) {

    //         return response()->json([
    //             'status' => 422,
    //             'errors' => $validator->messages()
    //         ], 422);
    //     } else {

    //         $order = Order::create([
    //             'user_id' => $user->id,
    //             'food_id' => $request->food_id,
    //             'quantity' => $request->quantity,
    //             'remark' => $request->remark,
    //             'table_no' => $request->table_no,
    //         ]);

    //         if ($order) {

    //             return response()->json([
    //                 'status' => true,
    //                 'Orders' => "Order Created Successfully"
    //             ], 200);
    //         } else {

    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Something Went Wrong'
    //             ], 500);
    //         }
    //     }
    // }


    public function getRestaurant(Request $request)
{
    $query = $request->input('name'); // Assuming 'name' is the parameter for the restaurant name search

    $restaurants = Restaurant::query();

    // If a search query is provided, filter restaurants by name
    if ($query) {
        $restaurants->where('name', 'like', '%' . $query . '%');
    }

    $restaurants = $restaurants->get();

    if ($restaurants->count() > 0) {
        return response()->json([
            'status' => true,
            'message' => "Successfully list restaurant",
            'data' => $restaurants
        ], 200);
    } else {
        return response()->json([
            'status' => false,
            'message' => 'No Records Found'
        ], 404);
    }
}

}
