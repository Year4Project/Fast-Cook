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

        // Define the fixed exchange rate
        $exchangeRate = 4100;

        // Count total payments in USD
        $totalUSD = Payment::where('restaurant_id', $restaurantId)
            ->where('currency', 'USD')
            ->sum('amount');

        // Count total payments in KHR
        $totalKHR = Payment::where('restaurant_id', $restaurantId)
            ->where('currency', 'KHR')
            ->sum('amount');

        // Convert total USD to KHR based on the fixed exchange rate
        $totalKHRFromUSD = $totalUSD * $exchangeRate;

        // Convert total KHR to USD based on the fixed exchange rate
        $totalUSDFromKHR = $totalKHR / $exchangeRate;

        // Sum total amounts in KHR and USD
        $totalAmountKHR = $totalKHRFromUSD + $totalKHR;
        $totalAmountUSD = $totalUSD + $totalUSDFromKHR;

        // Format amounts
        $formattedUSD = number_format($totalUSD, 2);
        $formattedKHR = number_format($totalKHR, 2);
        $formattedTotalKHR = number_format($totalAmountKHR, 2);
        $formattedTotalUSD = number_format($totalAmountUSD, 2);

        // Return counts in an array
        return [
            'USD' => $formattedUSD,
            'KHR' => $formattedKHR,
            'TOTAL_KHR' => $formattedTotalKHR,
            'TOTAL_USD' => $formattedTotalUSD
        ];
    }
}
