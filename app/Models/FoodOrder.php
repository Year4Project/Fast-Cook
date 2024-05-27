<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodOrder extends Model
{
    use HasFactory;
    protected $table = 'food_order';

    protected $fillable = [
        'food_id',
        'order_id',
        'quantity',
        'created_at',
        'updated_at'

    ];
    public $timestamps = true;

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }


    public static function getTotalOrderOnline()
    {

        $user = Auth::user();
        $restaurantId = $user->restaurant->id;

        $totalAmount = self::select(
            DB::raw('SUM(foods.price * food_order.quantity) as total_amount')
        )
        ->join('orders', 'food_order.order_id', '=', 'orders.id')
        ->join('foods', 'food_order.food_id', '=', 'foods.id')
        ->where('orders.restaurant_id', $restaurantId) // Filter by restaurant_id
        ->value('total_amount'); // Get the single value
            // dd($totalAmount);
    return $totalAmount;
    }
}
