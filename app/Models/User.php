<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Request;
use Laravel\Sanctum\HasApiTokens;
// use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

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
    protected static function boot(){
        parent::boot();
        self::creating(function ($user){
            $getUser = self::orderBy('user_id','desc')->first();
            if ($getUser){
                $lastestID = intval(substr($getUser->user_id,3));
                $nextID = $lastestID + 1;
            } else {
                $nextID = 1;
            }
            $user->user_id = 'KHF_'.sprintf("%03s",$nextID);
            while(self::where('user_id',$user->user_id)->exists()) {
                $nextID++;
                $user->user_id = 'KHF_' . sprintf("%03s", $nextID);
            }
        });
    }

    // Relationship User has many restaurant
    public function restaurant()
    {
        return $this->hasOne(Restaurant::class);
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
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
        //     // ->where('is_delete', '=', 0);

        // if(!empty(Request::get('name'))) {
        //     $return = $return->where('name', 'like', '%'.Request::get('name'). '%');
        // }

        // if(!empty(Request::get('email'))) {
        //     $return = $return->where('email', 'like', '%'.Request::get('email'));
        // }

        // if(!empty(Request::get('date'))) {
        //     $return = $return->whereDate('created_at', 'like', '%'.Request::get('date'));
        // }

        $return = $return->orderBy('id', 'desc')
                            ->paginate(5);

        return $return;
    }

    public static function getSingle($id)
    {
        return self::find($id);
    }



    public function order(){
        return $this->hasMany(Order::class);
    }



}
