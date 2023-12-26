<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function posSystem(){
        $data['getFood'] = Food::getFood();
        $data['header_title'] = 'List Food';
        return view('owner.pos.pos_system',$data);
    }
}
