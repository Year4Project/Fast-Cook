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

    // Validate the incoming restaurant data
    $request->validate([
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required',
        // You may need additional validation rules here depending on your requirements
    ]);

    // Create the restaurant associated with the user
    $restaurant = new Restaurant();
    $restaurant->name = $request->name;
    $restaurant->address = $request->address;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $randomStr = date('Ymdhis') . Str::random(20);
        $filename = strtolower($randomStr) . '.' . $ext;
        $file->move(public_path('upload/restaurant/'), $filename);
        $imageUrl = url('upload/restaurant/' . $filename);
        $restaurant->image = $imageUrl;
    }

    // Associate the restaurant with the user
    $user->restaurant()->save($restaurant);

    // Redirect to a success page or return a success response
    return redirect('admin/restaurant/showRestaurant')->with('success', "User and restaurant successfully created.");
}


    public function edit(string $restaurantId, $userId)
    {
        $data['user'] = user::FindOrFail($userId);
        $data['restaurant'] = Restaurant::FindOrFail($restaurantId);

            // dd($restaurant);
            return view('admin.restaurant.edit',$data);

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

    public function editUserAndRestaurant(Request $request, $userId, $restaurantId)
{
    // Validate the incoming user data
    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'phone' => 'required'
    ]);

    // Create the user
    $user = User::findOrFail($userId);
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->password = Hash::make($request->password);
    $user->user_type = 2; // Assuming user_type 2 represents restaurant owners
    $user->save();

    // Validate the incoming restaurant data
    $request->validate([
        'name' => 'required',
        'address' => 'required',
        // You may need additional validation rules here depending on your requirements
    ]);

    // Create the restaurant associated with the user
    $restaurant = Restaurant::findOrFail($restaurantId);
    $restaurant->name = $request->name;
    $restaurant->address = $request->address;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $randomStr = date('Ymdhis') . Str::random(20);
        $filename = strtolower($randomStr) . '.' . $ext;
        $file->move(public_path('upload/restaurant/'), $filename);
        $imageUrl = url('upload/restaurant/' . $filename);
        $restaurant->image = $imageUrl;
    }

    // Associate the restaurant with the user
    $user->restaurant()->save($restaurant);

    // Redirect to a success page or return a success response
    return redirect('admin/restaurant/showRestaurant')->with('success', "User and restaurant successfully Update.");
}





    public function delete($id)
    {
        $owner = User::findOrFail($id);
        $owner->restaurant->delete();
        $owner->delete();

        return redirect('admin/restaurant/showRestaurant')->with('success', "Admin successfully delete.");
    }
}
