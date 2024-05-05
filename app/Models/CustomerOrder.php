<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CustomerOrder extends Model
{
    use HasFactory;
    protected $table = 'customers_order';
    protected $fillable = [
        'restaurant_id',
        'customer_id',
        'ordernumber',
        'table_number',
        'status',
        'total_amount'
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

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function foods()
    {
        return $this->hasManyThrough(Food::class, OrderItem::class);
    }
    

    // Define the payment relationship
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    
}
