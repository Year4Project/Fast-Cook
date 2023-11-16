<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'oPrice',
        'dPrice',
        'image',
        'restaurant_id',
        'code',
        'status',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public static function getFood()
    {
        $return = Food::select('food.*','restaurants.*','food.id','food.image')
        ->join('restaurants', 'restaurants.id', '=', 'food.restaurant_id');
        // ->where('user_type', '=', 2);

        $return = $return->orderBy('food.restaurant_id', 'desc')
                        ->paginate(5);
        return $return;
    }
}
