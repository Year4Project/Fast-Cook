<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CustomerOrderFood extends Model
{
    use HasFactory;

    protected $table = 'customer_order_food';
    protected $fillable = [
        'restaurant_id',
        'order_id',
        'name',
        'image',
        'description',
        'price',
        'quantity',
        'total',
        'payment_method',
        'payment_usd',
        'payment_khr'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Assuming the relationship name is customer_order_food
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
    public function customerOrder()
    {
        return $this->belongsTo(CustomerOrder::class, 'order_id');
    }

    public static function getCustomerOrders($orderId)
    {

        $customerOrder = CustomerOrder::find($orderId);
        $customerOrderFoods = $customerOrder->customerOrderFoods;

        return $customerOrderFoods;
    }

//     public static function getCustomerOrders($orderId)
// {
//     $customerOrder = CustomerOrder::find($orderId);
//     $customerOrderFoods = $customerOrder->customerOrderFoods;

//     // Define conversion rate for USD to KHR
//     $usdToKhrConversionRate = 4100; // Example conversion rate, replace with your actual rate

//     // Iterate through each customer order food item
//     foreach ($customerOrderFoods as $orderFood) {
//         // Initialize the converted payment amount
//         $convertedPaymentAmount = 0;

//         // Check the currency and calculate the payment amount accordingly
//         if ($orderFood->currency === 'USD') {
//             // If the currency is USD, no conversion needed
//             $convertedPaymentAmount = $orderFood->payment;
//         } elseif ($orderFood->currency === 'KHR') {
//             // If the currency is KHR, convert USD to KHR
//             $convertedPaymentAmount = $orderFood->payment * $usdToKhrConversionRate;
//         }

//         // Set the converted payment amount
//         $orderFood->converted_payment = $convertedPaymentAmount;
//     }

//     return $customerOrderFoods;
// }

}
