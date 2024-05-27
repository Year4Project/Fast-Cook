<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';


    protected $fillable = [
        'restaurant_id',
        'name',
        'phone',
        'email',
    ];

    public function orders()
    {
        return $this->hasMany(CustomerOrder::class);
    }

//     public static function getCustomerOrders($orderId)
// {
//     $user = Auth::user();
//     $restaurant = $user->restaurant->id;

//     // Retrieve the customer order with its associated order items and their associated foods
//     $customerOrder = CustomerOrder::with('orderItems.food')->where('restaurant_id', $restaurant)->where('id', $orderId)->first();

//     // If you want to check the data, you can use dd()
//     // dd($customerOrder);

//     return $customerOrder;
// }

public static function getCustomerOrders($orderId)
{
    // Retrieve the currently authenticated user
    $user = Auth::user();

    // Check if the user is authenticated and has a restaurant associated with them
    if ($user && $user->restaurant) {
        // Retrieve the restaurant
        $restaurant = $user->restaurant;

        // Retrieve the customer order with its associated order items, payment, and their associated foods
        $customerOrder = CustomerOrder::with(['orderItems.food','customer', 'payment'])
            ->where('restaurant_id', $restaurant->id)
            ->where('id', $orderId)
            ->first();

        // If you want to check the data, you can use dd()
        // dd($customerOrder);

        return $customerOrder;
    } else {
        // Handle the case where the user is not authenticated or has no associated restaurant
        return null;
    }
}


// get data customer order to dashborad
// public static function getTotalOrder()
// {
//     // Retrieve the currently authenticated user
//     $user = Auth::user();

//     // Check if the user is authenticated and has a restaurant associated with them
//     if ($user && $user->restaurant) {
//         // Retrieve the restaurant
//         $restaurant = $user->restaurant;

//         // Retrieve the customer order with its associated order items, payment, and their associated foods
//         $customerOrder = CustomerOrder::with(['orderItems.food','customer', 'payment'])
//             ->where('restaurant_id', $restaurant->id)
//             ->first();

//         // If you want to check the data, you can use dd()
//         dd($customerOrder);

//         return $customerOrder;
//     } else {
//         // Handle the case where the user is not authenticated or has no associated restaurant
//         return null;
//     }
// }



}
