<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'food_id',
        'quantity',
        'table_note',
        'remark'
    ];

 
    // Relationship order has many menu
    public function menus(){
        return $this->hasMany(Menu::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}
