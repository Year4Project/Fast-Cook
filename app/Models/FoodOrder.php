<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FoodOrder extends Model
{
    use HasFactory;
    protected $table = 'food_order';
    public $timestamps = true;

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    static public function getUserOrder()
    {
        $user = Auth::user();

        $return = self::select('food_order.food_id','foods.*')
                    ->join('orders','orders.id','=','food_order.order_id')
                    ->join('foods','foods.id','=','food_order.food_id')
                    // ->join('users','users.id','=','food_order.user_id')
                    ->where('orders.restaurant_id', $user->id);

        $return = $return->orderBy('orders.id', 'desc')
            ->paginate(20);

        return $return;
    }
}
