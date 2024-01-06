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
    

    static public function getOrderUser()
    {
        // Get the authenticated user
        $user = Auth::user();
        $restaurantId = $user->restaurant->id;

        // Latest Orders Subquery
        $latestOrdersSubquery = DB::table('food_order')
            ->select(
                'users.id as user_id',
                'users.first_name',
                'users.last_name',
                'orders.restaurant_id',
                DB::raw('MAX(food_order.id) as latest_order_id')
            )
            ->join('orders', 'food_order.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'orders.restaurant_id');

        // Main Eloquent Query
        $foodOrders = FoodOrder::with(['food', 'order.user', 'order.restaurant'])
            ->joinSub($latestOrdersSubquery, 'latest_orders', function ($join) {
                $join->on('food_order.id', '=', 'latest_orders.latest_order_id');
            })
            ->join('orders', 'food_order.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('foods', 'food_order.food_id', '=', 'foods.id')
            ->where('orders.restaurant_id', '=', $restaurantId)
            ->select(
                'users.id as user_id',
                'users.first_name',
                'users.last_name',
                'food_order.*',
                'orders.restaurant_id',
                'orders.total_quantity',
                'foods.price',
                DB::raw('SUM(food_order.quantity *  foods.price) as price_total') // Calculate total price
            )
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'food_order.id', 'orders.restaurant_id')
            ->orderBy('orders.id', 'DESC')
            ->paginate(10);

            return $foodOrders;
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
