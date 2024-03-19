<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CustomerOrder extends Model
{
    use HasFactory;
    protected $table = 'customer_order';
    protected $fillable = [
        'ordernumber',
        'total',
        'customername',
        'customerphone',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   

    public function customerOrderFoods()
    {
        return $this->hasMany(CustomerOrderFood::class, 'order_id');
    }

    // public static function getCustomerOrders($orderId)
    // {
    //     // $user = Auth::user()->restaurant->id;
    //     $order = CustomerOrder::find($orderId);

    //     if (!$order) {
    //         // Handle case when order is not found
    //         abort(404, 'Order not found');
    //     }
    //      dd($order);
    //     return $order;
    // }
}