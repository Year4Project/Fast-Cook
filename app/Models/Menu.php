<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'name',
        'code',
        'oPrice',
        'dPrice',
        'image',
        'stock'
    ];
    
    // Genterate Code Menu
    protected static function boot(){
        parent::boot();
        self::creating(function ($model){
            $getFood = self::orderBy('code','desc')->first();
            if ($getFood){
                $lastestID = intval(substr($getFood->code,3));
                $nextID = $lastestID + 1;
            } else {
                $nextID = 1;
            }
            $model->code = 'KHF_'.sprintf("%03s",$nextID);
            while(self::where('code',$model->code)->exists()) {
                $nextID++;
                $model->code = 'KHF_' . sprintf("%03s", $nextID);
            }
        });
    }
    // Restaurant belongsTo With Menu
    public function restaurants(){
        return $this->belongsTo(Restaurant::class);
    }

    public function orders(){
        return $this->hasMany(Order::class,'id');
    }
}
