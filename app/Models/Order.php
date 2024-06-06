<?php

namespace App\Models;

use App\Events\OrderStatusUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'user_id', 'ordernumber', 'restaurant_id', 'items', 'table_no', 'remark', 'total_quantity', 'payment_method_id', 'status'
    ];

    protected $casts = [
        'items' => 'json',
    ];

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }


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
        $getOrderUser = Order::where('restaurant_id', $user->id)
            ->with(['user', 'payment_method']) // Eager load the payment_method relationship
            ->orderBy('id', 'DESC')
            ->paginate(10);


        // dd($getOrderUser);
        return $getOrderUser;
    }


    public static function getOrderDetails($orderId)
    {
        // $user = Auth::user()->restaurant->id;
        $order = Order::with(['user', 'foods', 'restaurant'])->find($orderId);

        if (!$order) {
            // Handle case when order is not found
            abort(404, 'Order not found');
        }
        // dd($order);
        return $order;
    }
    public function foodOrders()
    {
        return $this->hasMany(FoodOrder::class);
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

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->save();
        event(new OrderStatusUpdated($this));
    }
}
