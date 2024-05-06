<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Category;
use App\Models\CustomerOrder;
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

        if (Auth::user()->user_type == 1) {
            $data['total_user'] = User::count();
            $data['total_restaurant'] = Restaurant::count();
            return view('admin.dashboard', $data);

        } else if (Auth::user()->user_type == 2) {
            $data['header_title'] = 'User Order Food';
            $data['getOrder'] = Order::where('restaurant_id', Auth::user()->restaurant->id)->count();
            $data['getFood'] = Food::where('restaurant_id', Auth::user()->restaurant->id)->count();
            $data['getStaff'] = Staff::getStaff()->count();
            $data['getTables'] = Scen::where('restaurant_id', Auth::user()->restaurant->id)->count();
            $data['getCategory'] = Category::where('restaurant_id', Auth::user()->restaurant->id)->count();
            $data['alerts'] = Alert::latest()->get();
            // $data['getTotalSales'] = CustomerOrder::where('restaurant_id', Auth::user()->restaurant->id);
            // $data['getTotalSales'] = CustomerOrder::sum('total');
            // $data['getTotalSales'] = CustomerOrder::where('restaurant_id', Auth::user()->restaurant->id)->sum('total');


            // $data['getOrderUser'] = Order::getOrderUser();
            $data['getOrderUser'] = Order::getUserOrders();
            // $data['totalPrice'] = Order::sum('total_price');
            return view('owner.dashboard', $data);
        }
        // else if (Auth::user()->user_type == 3)
        // {
        //     return view('user.dashboard',$data);

        // }
    }
}
