<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    // display restaurant
    public function showRestaurant()
    {
        $data['getRestaurant'] = Restaurant::getRestaurant();
        $data['header_title'] = 'Add Restaurant';

        return view('admin.restaurant.showRestaurant', $data);
    }

    // to view create restaurant
    public function create()
    {
        return view('admin.restaurant.create');
    }

    // Store restaurant
    public function createRestaurant(Request $request)
    {
        request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $owner = new User();

        $owner->first_name = $request->first_name;
        $owner->last_name = $request->last_name;
        $owner->phone = $request->phone;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->user_type = 2;
        $owner->save();

        $restaurant = new Restaurant();
        $restaurant->name = $request->name;
        $restaurant->address = $request->address;

        if (!empty($request->file('image'))) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename =     strtolower($randomStr) . '.' . $ext;

            // Move the uploaded image to the specified directory
            $file->move(public_path('upload/restaurant/'), $filename);

            // Generate the image URL
            $imageUrl = url('upload/restaurant/' . $filename);
            $restaurant->image = $imageUrl;
        }

        $restaurant->phone = $request->phone;

        $owner->restaurant()->save($restaurant);

        return redirect('admin/restaurant/showRestaurant')->with('success', "Restaurant successfully Create.");
    }

    public function edit(string $id)
    {
        // $data['getRestaurant'] = Restaurant::getRestaurant();
        // $data['getRestaurant'] = Restaurant::getSingle($id);
        // $data['header_title'] = 'Edit Restaurant';
        $owner = User::with('restaurant')->findOrFail($id);

        // dd($owner);
            return view('admin.restaurant.edit', compact('owner'));

    }

    public function updateRestaurant(Request $request, $id)
    {

        request()->validate([
            'email' => 'required|email'
        ]);

        $restaurant = Restaurant::getSingle($id);

        $restaurant->name = $request->name;
        $restaurant->email = $request->email;
        $restaurant->address = $request->address;

        if (!empty($request->file('image'))) {
            if (!empty($restaurant->getProfile())) {
                unlink('upload/profile/' . $restaurant->image);
            }
            $ext = $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile/', $filename);

            $restaurant->image = $filename;
        }

        $restaurant->phone = $request->phone;
        $restaurant->user_type = 2;

        $restaurant->save();

        return redirect('admin/restaurant/showRestaurant')->with('success', "Restaurant successfully Update.");
    }

    public function delete($id)
    {
        $owner = User::findOrFail($id);
        $owner->restaurant->delete();
        $owner->delete();

        return redirect('admin/restaurant/showRestaurant')->with('success', "Admin successfully delete.");
    }
}
