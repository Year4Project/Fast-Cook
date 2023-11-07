<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';
        
        if (Auth::user()->user_type == 1)
            {
                $totalUser = User::count();
                $totalRestaurant = Restaurant::count();
                return view('admin.dashboard',$data, compact('totalUser', 'totalRestaurant'));

            } else if (Auth::user()->user_type == 2)
            {
                
                $totalOrder = Order::count();
                return view('owner.dashboard',$data ,compact('totalOrder'));

            } 
            // else if (Auth::user()->user_type == 3)
            // {
            //     return view('user.dashboard',$data);

            // } 
    }
}
