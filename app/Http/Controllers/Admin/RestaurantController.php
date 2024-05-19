<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function Sodium\compare;

class RestaurantController extends Controller
{
    // display restaurant
    public function showRestaurant()
    {
        $data['getRestaurant'] = Restaurant::getRestaurant();
        // dd($data['getRestaurant']);
        $data['header_title'] = 'List Restaurant';
        // $restaurant = Restaurant::all();

        return view('admin.restaurant.showRestaurant', $data);
    }

    // to view create restaurant
    public function create()
    {
        return view('admin.restaurant.create');
    }

    // Store restaurant
    public function createUserAndRestaurant(Request $request)
    {
        // Validate the incoming user data
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        // Create the user
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->user_type = 2; // Assuming user_type 2 represents restaurant owners
        $user->save();

        // If user creation successful, proceed to create restaurant
        if ($user) {
            // Validate the incoming restaurant data
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
            ]);

            // Create the restaurant associated with the user
            $restaurant = new Restaurant();
            $restaurant->name = $request->name;
            $restaurant->latitude = $request->latitude;
            $restaurant->longitude = $request->longitude;
            $restaurant->address = $request->address;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = date('Ymdhis') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/restaurant/'), $filename);
                $restaurant->image = url('upload/restaurant/' . $filename);
            }

            // Associate the restaurant with the user
            $user->restaurant()->save($restaurant);

            // Redirect to a success page or return a success response
            return redirect('admin/restaurant/showRestaurant')->with('success', "User $user->first_name $user->last_name and restaurant $restaurant->name successfully created.");
        }

        // If user creation failed, return with an error message
        return redirect()->back()->with('error', 'Failed to create user and restaurant.');
    }



    public function edit($id)
    {
        // Retrieve the restaurant data
        $restaurant = Restaurant::getSingle($id);

        // Check if the restaurant exists
        if (!empty($restaurant)) {
            // Retrieve the associated user data
            $user = $restaurant->user;

            // Check if the user exists
            if (!empty($user)) {
                $data['header_title'] = "Edit Restaurant";
                $data['restaurant'] = $restaurant;
                $data['user'] = $user;

                // dd($data);
                return view('admin.restaurant.edit', $data);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function updateUserAndRestaurant(Request $request, $userId)
    {
        // Validate the incoming user and restaurant data
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'nullable',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the user by ID
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Update user data
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->phone = $request->phone;
        $user->save();

        // If user update successful, proceed to update restaurant
        if ($user) {
            // Find the associated restaurant
            $restaurant = $user->restaurant;

            // Check if the restaurant exists
            if (!$restaurant) {
                return redirect()->back()->with('error', 'Restaurant not found.');
            }

            // Update restaurant data
            $restaurant->name = $request->name;
            $restaurant->latitude = $request->latitude;
            $restaurant->longitude = $request->longitude;
            $restaurant->address = $request->address;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = date('Ymdhis') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/restaurant/'), $filename);
                $restaurant->image = url('upload/restaurant/' . $filename);
            }

            $restaurant->save();

            // Redirect to a success page or return a success response
            return redirect('admin/restaurant/showRestaurant')->with('success', "User $user->first_name $user->last_name and restaurant $restaurant->name successfully updated.");
        }

        // If user update failed, return with an error message
        return redirect()->back()->with('error', 'Failed to update user and restaurant.');
    }




    public function deleteUserAndRestaurant($userId)
    {
        // Find the user by ID
        $user = User::find($userId);
    
        // If user not found, return with an error message
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
    
        // Attempt to delete the associated restaurant if it exists
        $restaurant = $user->restaurant;
        if ($restaurant) {
            // Delete the restaurant image file if it exists
            $imagePath = public_path('upload/restaurant/') . basename($restaurant->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
    
            // Delete the restaurant
            $restaurant->delete();
        }
    
        // Delete the user
        $user->delete();
    
        // Redirect to a success page or return a success response
        return redirect('admin/restaurant/showRestaurant')->with('success', "User and associated restaurant successfully deleted.");
    }
    



    public function updateStatus($id)
    {
        $getStatus = Restaurant::select('status')->where('id', $id)->first();
        // dd($getStatus);
        if ($getStatus->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        Restaurant::where('id', $id)->update(['status' => $status]);

        return redirect('admin/restaurant/showRestaurant')->with('success', "status successfully update.");
    }
    

}

  
