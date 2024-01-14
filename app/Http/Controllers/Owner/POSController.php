<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class POSController extends Controller
{
    public function posSystem(){
        $user = Auth::user();
        $restaurant = $user->restaurant->foods()->get();

        // dd($restaurant);
        $data['header_title'] = 'List Food';
        return view('owner.pos.pos_system',compact('user', 'restaurant'));
    }
}
