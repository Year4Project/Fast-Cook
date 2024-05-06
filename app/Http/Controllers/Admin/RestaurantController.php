<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function Sodium\compare;

class RestaurantController extends Controller
{
    // display restaurant
    public function showRestaurant()
    {
        $data['getRestaurant'] = Restaurant::getRestaurant();
        $data['header_title'] = 'Add Restaurant';
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
    

    // public function updateRestaurant(Request $request, $restaurantId)
    // {

    //     // Validate the incoming request data
    // $request->validate([
    //     'name' => 'required',
    //     'address' => 'required',
    //     'phone' => 'required',
    //     // You may need additional validation rules here depending on your requirements
    // ]);

    // // Find the restaurant by ID
    // $restaurant = Restaurant::findOrFail($restaurantId);


    // // Update the restaurant attributes
    // $restaurant->name = $request->name;
    // $restaurant->address = $request->address;
    // $restaurant->phone = $request->phone;

    // // Check if a new image is uploaded
    // if ($request->hasFile('image')) {
    //     $file = $request->file('image');
    //     $ext = $file->getClientOriginalExtension();
    //     $randomStr = date('Ymdhis') . Str::random(20);
    //     $filename = strtolower($randomStr) . '.' . $ext;

    //     // Move the uploaded image to the specified directory
    //     $file->move(public_path('upload/restaurant/'), $filename);

    //     // Generate the image URL
    //     $imageUrl = url('upload/restaurant/' . $filename);

    //     // Update the restaurant's image attribute
    //     $restaurant->image = $imageUrl;
    // }

    // // Save the updated restaurant data
    // $restaurant->save();

    // // Redirect back to the page showing the edited restaurant
    // return redirect('admin/restaurant/showRestaurant')->with('success', "Restaurant successfully updated.");
    // }

//     public function editUserAndRestaurant(Request $request, $userId, $restaurantId)
// {
//     // Validate the incoming user data
//     $request->validate([
//         'first_name' => 'required',
//         'last_name' => 'required',
//         'email' => 'required|email|unique:users,email',
//         'password' => 'required',
//         'phone' => 'required'
//     ]);

//     // Create the user
//     $user = User::findOrFail($userId);
//     $user->first_name = $request->first_name;
//     $user->last_name = $request->last_name;
//     $user->email = $request->email;
//     $user->phone = $request->phone;
//     $user->password = Hash::make($request->password);
//     $user->user_type = 2; // Assuming user_type 2 represents restaurant owners
//     $user->save();

//     // Validate the incoming restaurant data
//     $request->validate([
//         'name' => 'required',
//         'address' => 'required',
//         // You may need additional validation rules here depending on your requirements
//     ]);

//     // Create the restaurant associated with the user
//     $restaurant = Restaurant::findOrFail($restaurantId);
//     $restaurant->name = $request->name;
//     $restaurant->address = $request->address;

//     if ($request->hasFile('image')) {
//         $file = $request->file('image');
//         $ext = $file->getClientOriginalExtension();
//         $randomStr = date('Ymdhis') . Str::random(20);
//         $filename = strtolower($randomStr) . '.' . $ext;
//         $file->move(public_path('upload/restaurant/'), $filename);
//         $imageUrl = url('upload/restaurant/' . $filename);
//         $restaurant->image = $imageUrl;
//     }

//     // Associate the restaurant with the user
//     $user->restaurant()->save($restaurant);

//     // Redirect to a success page or return a success response
//     return redirect('admin/restaurant/showRestaurant')->with('success', "User and restaurant successfully Update.");
// }

public function updateUserAndRestaurant(Request $request, $userId)
{
    // Validate the incoming user data
    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:users,email,' . $userId,
        'password' => 'nullable' // Allow password to be nullable for update
    ]);

    // Find the user
    $user = User::findOrFail($userId);

    // Update the user details
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    // Update password only if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // Save the user
    $user->save();

    // If user update successful, proceed to update restaurant
    if ($user) {
        // Validate the incoming restaurant data
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for image upload
        ]);

        // Find or create the associated restaurant
        $restaurant = $user->restaurant ? $user->restaurant : new Restaurant();

        // Update the restaurant details
        $restaurant->name = $request->name;
        $restaurant->address = $request->address;

        // Update restaurant image if provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('Ymdhis') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/restaurant/'), $filename);
            $restaurant->image = url('upload/restaurant/' . $filename);
        }

        // Associate the restaurant with the user
        $user->restaurant()->save($restaurant);

        // Redirect to a success page or return a success response
        return redirect('admin/restaurant/showRestaurant')->with('success', "User $user->first_name $user->last_name and associated restaurant successfully updated.");
    }

    // If user update failed, return with an error message
    return redirect()->back()->with('error', 'Failed to update user and associated restaurant.');
}





    public function delete($id)
    {
        $owner = User::findOrFail($id);
        $owner->restaurant->delete();
        $owner->delete();

        return redirect('admin/restaurant/showRestaurant')->with('success', "Admin successfully delete.");
    }
}
