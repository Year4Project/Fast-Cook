<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Food extends Model
{
    use HasFactory;
    protected $table = 'foods';
    protected $fillable = [
        'restaurant_id',
        'name',
        'code',
        'oPrice',
        'dPrice',
        'description',
        'image',
        'status',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'food_orders')->withPivot('quantity');
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getFood()
    {
        $user = Auth::user();
        $return = self::select('foods.*')
            ->join('users','users.id','=','foods.restaurant_id')
            ->where('restaurant_id', $user->id);

            $return = $return->orderBy('foods.id', 'desc')
            ->paginate(5);

        return $return;
    }
}
