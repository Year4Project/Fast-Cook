<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class RestaurantControllerApi extends Controller
{

    /**
     * Function fo get all food another restaurant
     * It can searching food name and price
     */

    public function getAllFood(Request $r)
    {
        try {
            $user = JWTAuth::user();

            $food = Food::query();

            // Add join with the restaurant table
            $food->join('restaurants', 'foods.restaurant_id', '=', 'restaurants.id');

            // Select the columns you want
            $food->select('foods.*', 'restaurants.name as restaurant_name');

            // for searching
            if ($r->keyword) {
                $food->where('foods.name', 'LIKE', "%$r->keyword%")
                    ->orWhere('foods.price', $r->keyword)
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
                    'status' => true,
                    'message' => 'No Records Found',
                    'data' => null // returning null instead of an empty array
                ], 200);
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error retrieving food: ' . $e->getMessage());
            return response()->json([
                'status' => true,
                'message' => 'Error retrieving food. Please try again later.',
                'data' => null
            ], 200);
        }
    }


    /**
     * This function for get List food by restaurant ID
     */

     public function getListFood(Request $r, $id, $type = null)
     {
         try {
             $user = JWTAuth::user();
     
             $foodQuery = DB::table('foods')->where("restaurant_id", $id);
     
             if ($r->keyword) {
                 $foodQuery->where(function ($query) use ($r) {
                     $query->where('name', 'LIKE', "%$r->keyword%")
                         ->orWhere('dPrice', $r->keyword);
                 });
             }
             
             $type = $r->query('type');

             if ($type) {
                 $foodQuery->where('type', $type);
             }
     
             $food = $foodQuery->get();
     
             if ($food->isNotEmpty()) {
                 return response()->json([
                     'status' => true,
                     'message' => "Successfully listed food",
                     'data' => $food,
                     'user' => $user
                 ], 200);
             } else {
                 return response()->json([
                     'status' => true,
                     'message' => 'No Records Found',
                     'data' => []
                 ], 200);
             }
         } catch (\Exception $e) {
             // Log the error for debugging
             Log::error('Error retrieving food list: ' . $e->getMessage());
             return response()->json([
                 'status' => false,
                 'message' => 'Error retrieving food list. Please try again later.',
                 'data' => null
             ], 500);
         }
     }
     

    /**
     * This function for get all restaurant
     * For API this fucntion can serching data
     */

    public function getRestaurant(Request $request)
    {
        try {
            $query = $request->input('keyword');

            $restaurants = Restaurant::query();

            if ($query) {
                $restaurants->where('name', 'like', '%' . $query . '%');
            }

            $restaurants = $restaurants->get();

            if ($restaurants->count() > 0) {
                return response()->json([
                    'status' => true,
                    'message' => "Successfully listed restaurant",
                    'data' => $restaurants
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Records Found',
                    'data' => []
                ], 200);
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error retrieving restaurants: ' . $e->getMessage());
            return response()->json([
                'status' => true,
                'message' => 'Error retrieving restaurants. Please try again later.',
                'data' => null
            ], 500);
        }
    }
}
