<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

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

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
}
