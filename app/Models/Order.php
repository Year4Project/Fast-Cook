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
        'user_id',
        'food_id',
        'quantity',
        'table_no',
        'remark'
    ];

 
    // Relationship order has many menu
    public function menus(){
        return $this->belongsTo(Menu::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    static public function getOrder()
    {
        $return = Order::select('orders.*','users.first_name', 'users.last_name')
                    ->join('users','users.id','=','orders.user_id');
                    
                    // ->join('restaurants','restaurants.id','=','orders.user_id');
                    // ->where('orders.user_id','=', Auth::user()->id);

        $return = $return->orderBy('orders.id', 'desc')
            ->paginate(5);

        return $return;
    }

    
    static public function getOrderUser($getFoodUser)
    {
        $return = Order::select('orders.*','menus.*', 'users.first_name', 'users.last_name',)
                    ->join('users','users.id','=','orders.user_id')
                    ->join('menus','menus.id','=','orders.food_id')
                    ->where('orders.user_id','=', $getFoodUser );
                    
        $return = $return->orderBy('orders.id', 'desc')
            ->paginate(5);

        return $return;
    }
    
    
}
