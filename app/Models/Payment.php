<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'restaurant_id',
        'customer_order_id',
        'amount',
        'currency',
        'payment_method',
    ];

    static public function countPaymentsByCurrency()
    {
        // Assuming you already have an authenticated user
        $user = auth()->user();
        $restaurantId = $user->restaurant->id;

        // Count total payments in USD
        $totalUSD = Payment::where('restaurant_id', $restaurantId)
            ->where('currency', 'USD')
            ->sum('amount');

        // Convert total USD to KHR based on the fixed exchange rate
        $totalKHRFromUSD = $totalUSD * 4100;

        // Count total payments in KHR
        $totalKHR = Payment::where('restaurant_id', $restaurantId)
            ->where('currency', 'KHR')
            ->sum('amount');
        
        // sum total USD and KHR
        $totalAmount = $totalKHRFromUSD + $totalKHR;

        // Format amounts
        $formattedUSD = number_format($totalUSD);
        $formattedKHR = number_format($totalKHR);
        $formattedTotal = number_format($totalAmount);

        // Return counts in an array
        return [
            'USD' => $formattedUSD,
            'KHR' => $formattedKHR,
            'TOTAL' => $formattedTotal
        ];
    }
}
