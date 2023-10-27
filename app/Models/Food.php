<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'name','code','oPrice','dprice','image','stock'];

    static public function getSingle($id)
    {
        return self::find($id);
    }

    
}
