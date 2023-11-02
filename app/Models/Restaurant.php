<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    
    protected $fillable = ['restaurant_name', 'address','user_id'];

    // Restaurant belongsto User
    public function users(){
        return $this->belongsTo(User::class);
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    // Restaurant Relationship With Menu
    public function menus(){
        return $this->hasMany(Menu::class,'restaurant_id','id');
    }

}
