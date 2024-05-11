<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function profile(){
        $user = Auth::user();
        $restaurant = $user->restaurant;
    
        // Debugging
        // dd($restaurant);
    
        // Pass both $user and $restaurant to the view
        return view('owner.profile.profile', compact('user', 'restaurant'));
    }
    

    public function edit()
    {
        $user = Auth::user();

        // dd($user);
        return view('owner.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
    
        // Ensure the authenticated user is updating their own profile
        if ($user->id !== $request->user()->id) {
            abort(403); // Unauthorized
        }
    
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Update image validation rules
        ]);
    
        // Update profile details
        $user->update($validatedData);
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $filename = date('Ymdhis') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                // Ensure the directory exists, if not, create it
                $directory = public_path('upload/user/');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
                // Move the uploaded file to the directory
                $file->move($directory, $filename);
                // Update the user's image URL
                $user->image_url = url('upload/user/' . $filename);
            } else {
                // Handle invalid file
                return redirect()->route('owner.profile.edit')->with('error', 'Invalid file uploaded.');
            }
        }
    
        return redirect()->route('owner.profile.edit')->with('success', 'Profile updated successfully.');
    }
    
    


    public function updateImage(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Update image validation rules
        ]);

        // Update the image if provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($user->image_url) {
                Storage::delete(parse_url($user->image_url, PHP_URL_PATH));
            }

            // Store the new image
            $imagePath = $request->file('image')->store('profile_images', 'public');

            // Update the user's image_url
            $user->update(['image_url' => url('storage/' . $imagePath)]);
        }

        return redirect()->route('profile.view')->with('success', 'Profile image updated successfully.');
    }
}
