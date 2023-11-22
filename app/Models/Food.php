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

    // public static function getFood()
    // {
    //     $return = self::select('food.*')
    //             ->join('restaurants','restaurants.owner_id', '=', 'food.restaurant_id')
    //             ->where('restaurants.owner_id','=',21);

    //     $return = $return->orderBy('id', 'desc')
    //                         ->paginate(5);
    //     return $return;
    // }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
