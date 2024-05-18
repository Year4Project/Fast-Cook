<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Request;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
// use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    use Notifiable;





    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'user_type',
        'restaurant_id',
        'image_url',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Generate automatic number or id
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            $getUser = self::orderBy('user_id', 'desc')->first();
            if ($getUser) {
                $lastestID = intval(substr($getUser->user_id, 3));
                $nextID = $lastestID + 1;
            } else {
                $nextID = 1;
            }
            $user->user_id = 'KHF_' . sprintf("%03s", $nextID);
            while (self::where('user_id', $user->user_id)->exists()) {
                $nextID++;
                $user->user_id = 'KHF_' . sprintf("%03s", $nextID);
            }
        });

        // static::deleting(function ($user) {
        //     // If user has associated restaurant, delete it
        //     if ($user->restaurant) {
        //         $user->restaurant->delete();
        //     }
        // });
    }

    // Relationship User has many restaurant
    // public function restaurant()
    // {
    //     return $this->hasOne(Restaurant::class);
    // }


    public function restaurant()
    {
        return $this->hasOne(Restaurant::class);
    }
    public function restaurants()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
    public function foods()
    {
        return $this->hasManyThrough(Food::class, Restaurant::class);
    }



    public static function getOwner()
    {
        $return = self::select('users.*')
            ->where('user_type', '=', 2);

        $return = $return->orderBy('id', 'desc')
            ->paginate(5);

        return $return;
    }


    public static function getAdmin()
    {
        $return = self::select('users.*')
            ->where('user_type', '=', 1);

        $return = $return->orderBy('id', 'desc')
            ->paginate(5);

        return $return;
    }

    public static function getSingle($id)
    {
        return self::find($id);
    }



    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }


    public function category()
    {
        return $this->hasMany(Category::class);
    }
}
