<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        // dd(Hash::make(12345));
        $data['header_title'] = 'Login';
        return view('auth/login',$data);

    }

    public function AuthLogin(Request $request)
     {
        // dd($request->all());
        $data['header_title'] = 'Dashboard';
        $remember = !empty($request->remember) ? true : false;
        if (Auth::attempt(['email' => $request->email,'password' => $request->password],$remember))
        {
            if (Auth::user()->user_type == 1)
            {
                return redirect('admin/dashboard');
            }
            else if (Auth::user()->user_type == 2)
            {
                return redirect('owner/dashboard');
            }
            // else if (Auth::user()->user_type == 3)
            // {
            //     return redirect('user/dashboard');
            // }

        } else
        {
            return redirect()->back();
        }
    }

    function registration(){
        return view('auth.registration');
    }


    function registrationPost(Request $request){
        $request->validate([
            'first_name' => 'required',
            'last_name'=> 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        if(!$user){
            return redirect(route(''))->with("success","Registration failed, try again.");
        }
        return redirect(route(''))->with("success","Registration seccess, Login to access the app");
    }




    public function logout() {
        Auth::logout();
        return redirect(url(''));
    }
}
