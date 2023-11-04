<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showAdmin(){
        $admin = User::all();
        // if($admin->user_type){
        //     $admin->user_type == 1;
        // }
        return view('admin.admin.showAdmin',compact('admin'));
    }
    public function add(){
        return view('admin.admin.add');
    }
    public function insert(Request $request){
        request()->validate([
            'first_name' => 'required',
            'last_name'=> 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'=> $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->user_type = 2;
        $user->save();

        return redirect('admin/admin/showAdmin')->with('success', "Admin successfully created.");
    }
    public function updateStatus($id){
        $getStatus = User::select('status')->where('user_id',$id)->first();
        if($getStatus->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        User::where('user_id',$id)->update(['status'=>$status]);
        return redirect('admin/admin/showAdmin')->with('success', "status successfully update.");
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.admin.edit', compact('user'));
    }
     
    // public function update(Request $request, $id) // Function for updating a user
    // {
    //     request()->validate([
    //         'email' => 'required|email|unique:users,email,'.$id,
    //         'phone' => 'required|unique:users|numeric'
    //     ]);

    //     $user = User::findOrFail($id);
    //     $user->first_name = trim($request->first_name);
    //     $user->last_name = trim($request->last_name);
    //     $user->email = trim($request->email);
    //     $user->phone = $request->phone;
    //     $user->password = Hash::make($request->password);
    //     if(!empty($request->password))
    //     {
    //         $user->password = Hash::make($request->password);
    //     }

    //     $user->save();

    //     return redirect('admin/admin/showAdmin')->with('success', "Admin successfully update.");
    // }

    public function delete($id) // Function to delete a user from the admin
    {
        $user = User::find(request()->id);
        $user->delete();

        return redirect('admin/admin/showAdmin')->with('success', "Admin successfully delete.");
    }
}

