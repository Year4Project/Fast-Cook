<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    public function showRestaurant(){

        // $data = User::with('restaurant')->get();
        $data = DB::table('users')
        ->join('restaurants', 'users.id', '=' , 'restaurants.user_id')
        // ->select('restaurants.*','users.first_name','users.last_name','users.email','users.phone')
        ->get();

        return view('admin.restaurant.showRestaurant',compact('data'));
    }

    public function create(){
        $restaurant = DB::table('restaurants')
                    ->join('users', 'users.id','=' ,'restaurants.user_id')
                    ->get();

        $user = DB::table('users')
                ->get();

        return view('admin.restaurant.create', ['restaurant'=> $restaurant,'user'=> $user]);
    }

    public function store(Request $request){

        $restaurant = new Restaurant;
        $restaurant->restaurants_name = $request->input('restaurants_name');
        $restaurant->address = $request->input('address');
        $restaurant->user_id = $request->input('user');
        $restaurant->save();

        return redirect('admin/restaurant/showRestaurant')->with('success', "Restaurant successfully created.");
    }

    public function edit(string $id){

        // $restaurant = Restaurant::find($id);
        $restaurant = DB::table('restaurants')
        ->join('users', 'users.id','=' ,'restaurants.user_id')
        // ->select('users.*','users.first_name','users.last_name','users')
        ->get();
        $user = DB::table('users')
            ->get();
        $restaurant = Restaurant::find(request()->id);
        
        return view('admin.restaurant.edit',['restaurant'=> $restaurant,'user'=> $user]);
    }

    public function updateRestaurant(Request $request, string $id){
        $restaurant = Restaurant::findOrFail($id);

        $restaurant->restaurants_name = $request->input('restaurants_name');
        $restaurant->address = $request->input('address');
        $restaurant->user_id = $request->input('user');
        $restaurant->save();

        return redirect('admin/restaurant/showRestaurant')->with('success', "Restaurant successfully updated.");
    }

    public function delete($id)
    {
        $restaurant = Restaurant::find(request()->id);
        $restaurant->delete();

        return redirect('admin/restaurant/showRestaurant')->with('success', "Admin successfully delete.");
    }
}
