<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scen extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_no',
        'restaurant_id',
        'table_code'
    ];

    static public function getScen()
    {
        $return = scen::select('scens.*','restaurants.id')
                    ->join('restaurants','restaurants.id','=','scens.restaurant_id');
                    
        $return = $return->orderBy('scens.id', 'desc')
            ->paginate(5);

        return $return;
    }

    
}
