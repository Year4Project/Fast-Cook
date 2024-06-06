<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use App\Models\Food;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            // Add condition to check food status
            $food->where('foods.status', 1); // Assuming 'status' column indicates the status of food

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
            Log::info('Entered getListFood method');

            // Retrieve the authenticated user
            $user = JWTAuth::user();
            Log::info('User retrieved: ' . json_encode($user));

            // Query to retrieve the food list along with the restaurant name
            $foodQuery = DB::table('foods')
                ->join('restaurants', 'foods.restaurant_id', '=', 'restaurants.id')
                ->where('foods.restaurant_id', $id)
                ->where('restaurants.status', '<>', 0) // Filter restaurants with status not equal to 0
                ->where('foods.status', 1) // Filter foods with status 1 (available)
                ->select('foods.*', 'restaurants.name as restaurant_name');

            // Add keyword search
            if ($r->has('keyword')) {
                $keyword = $r->input('keyword');
                Log::info('Keyword present: ' . $keyword);
                $foodQuery->where(function ($query) use ($keyword) {
                    $query->where('foods.name', 'LIKE', "%{$keyword}%")
                        ->orWhere('foods.dPrice', $keyword);
                });
            }

            // Add type filter
            if ($type) {
                Log::info('Type present: ' . $type);
                $foodQuery->where('foods.type', $type);
            }

            // Retrieve food data
            $food = $foodQuery->get();
            Log::info('Food query result: ' . json_encode($food));

            // Check if food records exist
            if ($food->isNotEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully listed food',
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
            Log::error('Error trace: ' . $e->getTraceAsString());

            return response()->json([
                'status' => false,
                'message' => 'Error retrieving food list. Please try again later.',
                'data' => null
            ], 500);
        }
    }








    /**
     * This function for get all restaurant that have status 1
     */
    public function getRestaurant(Request $request)
    {
        try {
            $query = $request->input('keyword');

            // Initialize the query builder for the Restaurant model
            $restaurants = Restaurant::query();

            // Add a condition to filter restaurants by the keyword if it exists
            if ($query) {
                $restaurants->where('name', 'like', '%' . $query . '%');
            }

            // Add a condition to filter restaurants that are 'available'
            $restaurants->where('status', 1);

            // Execute the query and get the results
            $restaurants = $restaurants->get();

            // Check if any restaurants were found and return the appropriate response
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
                'status' => false,
                'message' => 'Error retrieving restaurants. Please try again later.',
                'data' => null
            ], 500);
        }
    }

    /**
     * History API For Foods Order
     */

     
}
