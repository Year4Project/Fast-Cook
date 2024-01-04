<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    



    static public function getOrderUser($getFoodUser)
    {
        $return = Order::select('orders.*', 'foods.*', 'users.first_name', 'users.last_name', 'orders.id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('foods', 'foods.id', '=', 'orders.user_id')
            ->where('orders.id', '=', $getFoodUser);

        $return = $return->orderBy('orders.user_id', 'desc')
            ->paginate(20);

        return $return;
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
