<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable; // Correct class name
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Restaurant extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'address', 'image', 'email', 'status', 'phone'];

    static public function getSingle($id)
    {
        return self::find($id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getProfile()
    {
        if (!empty($this->image) && file_exists('upload/profile/' . $this->image)) {
            return url('upload/profile/' . $this->image);
        } else {
            return "";
        }
    }

    public static function getRestaurant()
    {
        $usersWithRestaurants = DB::table('users')
    ->join('restaurants', 'users.id', '=', 'restaurants.user_id')
    ->select('users.*', 'restaurants.name as restaurant_name', 'restaurants.address as restaurant_address', 'restaurants.image','restaurants.id as restaurant_id')
    ->get();

    // dd($usersWithRestaurants);


        return $usersWithRestaurants;
    }

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class, 'restaurant_id');
    }

    public function desrtory($userId){
        $user = DB::table('users')->where('id', $userId)->first();

if ($user) {
    // Delete the user
    DB::table('users')->where('id', $userId)->delete();

    // Delete associated restaurants
    DB::table('restaurants')->where('user_id', $userId)->delete();
}

    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

}
