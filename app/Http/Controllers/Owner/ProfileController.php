<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function profile(){
        $user = Auth::user();
        // dd($user);
        return view('owner.profile.profile',compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('owner.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Update image validation rules
        ]);

        // Update profile details
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
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


        return redirect()->route('owner.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
