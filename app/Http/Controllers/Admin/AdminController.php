<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Faker\Core\Number;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showAdmin(){
        $admin = User::all();
        return view('admin.admin.showAdmin',compact('admin'));
    }
    public function add(){
        return view('admin.admin.add');
    }
    public function insert(Request $request){
        request()->validate([
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users|numeric'
        ]);
        $user = new User();
        $user->first_name = trim($request->first_name);
        $user->last_name = trim($request->last_name);
        $user->email = trim($request->email);
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->user_type = '2';
        $user->save();

        return redirect('admin/admin/showAdmin')->with('success', "Admin successfully created.");
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.admin.edit', compact('user'));
    }
     
    public function update(Request $request, $id) // Function for updating a user
    {
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required|unique:users|numeric'
        ]);

        $user = User::findOrFail($id);
        $user->first_name = trim($request->first_name);
        $user->last_name = trim($request->last_name);
        $user->email = trim($request->email);
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        if(!empty($request->password))
        {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('admin/admin/showAdmin')->with('success', "Admin successfully update.");
    }

    public function delete($id) // Function to delete a user from the admin
    {
        $user = User::find(request()->id);
        $user->delete();

        return redirect('admin/admin/showAdmin')->with('success', "Admin successfully delete.");
    }
}

