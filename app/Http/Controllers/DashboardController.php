<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Scen;
use App\Models\Staff;
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
                // $data['getRecord'] = Order::getOrder();
                $data['header_title'] = 'User Order Food';
                // $data['getOrder'] = Order::getOrder()->count();
                // $data['getFood'] = Food::getFood()->count();
                $data['getStaff'] = Staff::getStaff()->count();
                $data['getTables'] = Scen::getQrcode()->count();
                return view('owner.dashboard',$data);

            }
            // else if (Auth::user()->user_type == 3)
            // {
            //     return view('user.dashboard',$data);

            // }
    }
}
