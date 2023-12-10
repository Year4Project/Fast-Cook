<?php

namespace App\Models;

use App\Models\Scen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address','image','email','status','phone'];



    // Restaurant belongsto User
     public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getProfile()
    {
        if(!empty($this->image) && file_exists('upload/profile/'.$this->image)) {
            return url('upload/profile/'.$this->image);
        } else {
            return "";
        }
    }

    static public function getRestaurant()
    {
        $return = self::select('restaurants.*','users.*')
                    ->join('users', 'users.id', '=', 'restaurants.user_id');

        $return = $return->orderBy('restaurants.id', 'desc')
                            ->paginate(5);
        return $return;
    }




}
