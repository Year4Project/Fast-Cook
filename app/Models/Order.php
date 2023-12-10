<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'restaurant_id',
        'user_id',
        'food_id',
        'quantity',
        'remark',
        'table_no',
    ];

 
    // Relationship order has many menu
    public function menus(){
        return $this->belongsTo(Food::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    static public function getOrder()
    {
        $user = Auth::user();
        $return = self::select('orders.*','users.first_name','users.last_name')
                    ->join('users','users.id','=','orders.user_id')
                    ->where('restaurant_id', $user->id);

        $return = $return->orderBy('orders.id', 'desc')
            ->paginate(20);

        return $return;
    }

    
    static public function getOrderUser($getFoodUser)
    {
        $return = Order::select('orders.*','food.*', 'users.first_name', 'users.last_name','orders.id')
                    ->join('users','users.id','=','orders.user_id')
                    ->join('food','food.id','=','orders.food_id')
                    ->where('orders.id','=', $getFoodUser );
                    
        $return = $return->orderBy('orders.food_id', 'desc')
            ->paginate(20);

        return $return;
    }
    
    
}
