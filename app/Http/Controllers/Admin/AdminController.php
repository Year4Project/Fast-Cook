<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function showAdmin()
    {
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = 'Owner Restaurant List';
        return view('admin.admin.showAdmin', $data);
    }

    public function add()
    {
        $data['header_title'] = "Add New Owner Restaurant";
        return view('admin.admin.add', $data);
    }

    public function insert(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
    
        // Create a new User instance
        $user = new User();
        $user->fill([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'phone' => $request->input('phone'), // If phone is optional
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'user_type' => 1 // Assuming 1 represents an admin user
        ]);
    
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = date('Ymdhis') . Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/user/'), $filename);
            $user->image_url = url('upload/user/' . $filename);
        }
    
        // Save the user
        $user->save();
    
        return redirect('admin/admin/showAdmin')->with('success', "Admin successfully created.");
    }
    
    public function updateStatus($id)
    {
        $getStatus = User::select('status')->where('user_id', $id)->first();
        if ($getStatus->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        User::where('user_id', $id)->update(['status' => $status]);
        return redirect('admin/admin/showAdmin')->with('success', "status successfully update.");
    }

    public function edit(string $id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Admin";
            return view('admin.admin.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
{
    // Validate the request data
    $validatedData = $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'email' => 'required|email|unique:users,email,'.$id,
        'password' => 'nullable',
    ]);

    // Find the user by ID
    $user = User::findOrFail($id);

    // Update the user attributes
    $user->fill([
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'phone' => $request->input('phone'), // If phone is optional
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password'])
    ]);

    // Handle image update if provided
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = date('Ymdhis') . Str::random(20) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('upload/user/'), $filename);
        $user->image_url = url('upload/user/' . $filename);
    }

    // Save the updated user
    $user->save();

    return redirect('admin/admin/showAdmin')->with('success', "Admin successfully updated.");
}


    public function delete($id) // Function to delete a user from the admin
    {
        $user = User::find(request()->id);
        $user->is_delete = 1;
        $user->delete();

        return redirect('admin/admin/showAdmin')->with('success', "Admin successfully delete.");
    }
}
