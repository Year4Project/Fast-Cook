<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items';

    protected $fillable = [
        'restaurant_id',
        'order_id',
        'food_id',
        'quantity',
        'notes'
    ];

    public function customerOrder()
    {
        return $this->belongsTo(CustomerOrder::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }
}
