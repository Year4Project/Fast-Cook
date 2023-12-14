<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FoodOrder extends Model
{
    use HasFactory;
    protected $table = 'food_order';
    public $timestamps = true;

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    
}
