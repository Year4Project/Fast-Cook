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
}
