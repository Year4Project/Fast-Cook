<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable; // Correct class name
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'address', 'image', 'email', 'status', 'phone'];

    public function user()
    {
        return $this->hasOne(User::class);
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
        $return = self::select('restaurants.*', 'users.*')
            ->join('users', 'users.id', '=', 'restaurants.user_id');

        $return = $return->orderBy('restaurants.id', 'desc')
            ->paginate(5);
        return $return;
    }

    public function category()
    {
        return $this->hasMany(Category::class);
    }
}
