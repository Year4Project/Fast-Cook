<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'food_id',
        'items',
        'quantity',
        'table_no',
        'remark',
        'total_quantity'

    ];
    protected $casts = [
        'items' => 'json',
    ];


    // Relationship order has many menu
    public function menus()
    {
        return $this->belongsTo(Food::class);
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'food_order')->withPivot('quantity');
    }
    public function foodss()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    public function food()
    {
        return $this->hasMany(FoodOrder::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function foodOrder()
    {
        return $this->hasMany(FoodOrder::class);
    }

    public static function getUserOrders()
    {
        // Get the authenticated user
        $user = Auth::user()->restaurant;

        // Retrieve all orders related to this restaurant
        $orders = Order::where('restaurant_id', $user->id)
            ->with(['user', 'foods'])
            ->orderBy('id', 'DESC')
            ->paginate(10); // <-- Add pagination here

        return $orders;
    }

        public static function getOrderDetails($orderId)
    {
        // $user = Auth::user()->restaurant->id;
        $order = Order::with(['user', 'foods'])->find($orderId);

        if (!$order) {
            // Handle case when order is not found
            abort(404, 'Order not found');
        }
        // dd($order);
        return $order;
    }


    public function getItemsAttribute($value)
    {
        $items = json_decode($value, true);

        return collect($items)->map(function ($item) {
            $food = Food::find($item['food_id']);
            $item['food'] = $food;

            return $item;
        });
    }
}
