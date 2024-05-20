<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $fillable = [
        'food_id',
        'restaurant_id',
        'quantity',
        'created_at',
        'updated_at',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    static public function getItem()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Handle the case where the user is not authenticated
            return null;
        }
        
        $user = Auth::user();
        $restaurantId = $user->restaurant->id;
    
        // Retrieve the cart items associated with the restaurant ID along with their related food items
        $cartItems = Cart::with('food')
            ->where('restaurant_id', $restaurantId)
            ->get();
    
        // If no cart items are found, return an empty array or handle it as needed
        if ($cartItems->isEmpty()) {
            return [];
        }
    
        // Return the retrieved cart items
        return $cartItems;
    }
    

    


    public static function deleteItem($cartItemId){
        $user = Auth::user();
        $restaurantId = $user->restaurant->id;
    
        // Find the cart item by ID and restaurant ID to ensure the user has permission to delete it
        $cartItem = Cart::where('id', $cartItemId)
                        ->where('restaurant_id', $restaurantId)
                        ->first();
    
        if ($cartItem) {
            $cartItem->delete();
            return ['status' => 'success', 'message' => 'Item deleted successfully.'];
        } else {
            return ['status' => 'error', 'message' => 'Item not found or you do not have permission to delete it.'];
        }
    }
    
    
    
}