<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Category;
use App\Models\CustomerOrder;
use App\Models\Food;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Models\Scen;
use App\Models\Staff;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


    public function dashboard()
    {

        $data['header_title'] = 'Dashboard';

        if (Auth::user()->user_type == 1) {
            $data['total_admin'] = User::where('user_type', 1)->count();
            $data['total_user'] = User::where('user_type', 3)->count();
            $data['restauran_available'] = Restaurant::where('status', 1)->count();
            $data['restauran_pending'] = Restaurant::where('status', 0)->count();

            return view('admin.dashboard', $data);

            // else if go to user type 2 for restaurants owner
        } else if (Auth::user()->user_type == 2) {
            $data['header_title'] = 'Dashboard';
            $data['getOrder'] = Order::where('restaurant_id', Auth::user()->restaurant->id)->count();
            $data['getFood'] = Food::where('restaurant_id', Auth::user()->restaurant->id)->count();

            $data['acceptedOrderCount'] = Order::where('restaurant_id', Auth::user()->restaurant->id)
                ->where('status', 'accepted')
                ->count();

            $data['pendingOrderCount'] = Order::where('restaurant_id', Auth::user()->restaurant->id)
                ->where('status', 'pending')
                ->count();
            $data['rejectedOrderCount'] = Order::where('restaurant_id', Auth::user()->restaurant->id)
                ->where('status', 'rejected')
                ->count();



            $data['getStaff'] = Staff::getStaff()->count();
            $data['getTables'] = Scen::where('restaurant_id', Auth::user()->restaurant->id)->count();
            $data['getCategory'] = Category::where('restaurant_id', Auth::user()->restaurant->id)->count();
            $data['alerts'] = Alert::latest()->get();
            
            $data['payment'] = Payment::countPaymentsByCurrency();
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
