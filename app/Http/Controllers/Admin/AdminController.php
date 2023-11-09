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
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = 'Owner Restaurant List';
        return view('admin.admin.showAdmin', $data);
    }

    public function add(){
        $data['header_title'] = "Add New Owner Restaurant";
        return view('admin.admin.add', $data);
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
        $data['getRecord'] = User::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['header_title'] = "Edit Admin";
            return view('admin.admin.edit', $data);
        }
        else
        {
            abort(404);
        }

        
    }
     
    public function update(Request $request, $id) // Function for updating a user
    {
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id
        ]);

        $user = User::getSingle($id);
        $user->first_name = trim($request->first_name);
        $user->last_name = trim($request->last_name);
        $user->email = trim($request->email);
        $user->phone = trim($request->phone);
        $user->password = Hash::make($request->password);
        if(!empty($request->password))
        {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('admin/admin/showAdmin')->with('success', "Admin successfully created.");
    }

    public function delete($id) // Function to delete a user from the admin
    {
        $user = User::find(request()->id);
        $user->is_delete = 1;
        $user->delete();

        return redirect('admin/admin/showAdmin')->with('success', "Admin successfully delete.");
    }
}

