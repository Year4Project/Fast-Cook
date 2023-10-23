<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showAdmin(){
        $admin = User::all();
        return view('admin.showAdmin',compact('admin'));
    }
    public function add(){
        return view('admin.add');
    }
    public function insert(Request $request){
        request()->validate([
            'email' => 'required|email|unique:users'
        ]);
        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type = '2';
        $user->save();

        return redirect('admin/showAdmin')->with('success', "Admin successfully created.");
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.edit', compact('user'));
    }
     
    public function update(Request $request, $id) // Function for updating a user
    {
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id
        ]);

        $user = User::findOrFail($id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        if(!empty($request->password))
        {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('admin/showAdmin')->with('success', "Admin successfully update.");
    }

    public function delete($id) // Function to delete a user from the admin
    {
        $user = User::find(request()->id);
        $user->delete();

        return redirect('admin/showAdmin')->with('success', "Admin successfully delete.");
    }
}
