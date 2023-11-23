<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getFood()
    {
        $user = Auth::user();
        $return = self::select('food.*')
            ->join('users','users.id','=','food.restaurant_id')
            ->where('restaurant_id', $user->id);

            $return = $return->orderBy('food.id', 'desc')
            ->paginate(5);

        return $return;
    }
}
