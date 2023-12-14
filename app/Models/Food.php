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
        return $this->hasMany(Order::class, 'food_id', 'id');
    }

    public function order()
    {
        return $this->belongsToMany(Order::class, 'food_order')->withPivot('quantity');
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getFood()
    {
        $user = Auth::user();

        if (!$user->restaurant) {
            // Handle the case where the user is not associated with a restaurant
            return redirect()->back()->with('error', 'You are not associated with a restaurant.');
        }
        $foods = Food::where('restaurant_id', $user->restaurant->id)->get();

        return $foods;
    }
}
