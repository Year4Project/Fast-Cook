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
        'restaurant_id'
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
}
