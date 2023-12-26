<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Staff extends Model
{
    use HasFactory;

    static public function getSingle($id)
    {
        return self::find($id);
    }
    public function getProfile()
    {
        if(!empty($this->image) && file_exists('upload/staff/'.$this->image)) {
            return url('upload/staff/'.$this->image);
        } else {
            return "";
        }
    }

    static public function getStaff()
    {
        $user = Auth::user()->restaurant->id;
        $return = self::select('staff.*')
            ->join('users','users.id','=','staff.restaurant_id')
            ->where('restaurant_id', $user);

            $return = $return->orderBy('staff.id', 'desc')
            ->paginate(5);

        return $return;
    }
}
