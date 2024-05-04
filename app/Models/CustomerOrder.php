<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CustomerOrder extends Model
{
    use HasFactory;
    protected $table = 'customers';
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
}
