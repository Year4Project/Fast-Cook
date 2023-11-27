<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Scen extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_no',
        'restaurant_id',
        'table_code'
    ];

    static public function getQrcode()
    {
        $user = Auth::user();
        $return = self::select('scens.*')
            ->join('users','users.id','=','scens.restaurant_id')
            ->where('restaurant_id', $user->id);

            $return = $return->orderBy('scens.id', 'desc')
            ->paginate(5);

        return $return;
    }

    
}
