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
        if(!empty(Auth::check())){
            if (Auth::user()->user_type == 1)
            {
                return redirect('admin/dashboard');
            }
            else if (Auth::user()->user_type == 2)
            {
                return redirect('owner/dashboard');
            }
            else if (Auth::user()->user_type == 3)
            {
                return redirect('user/dashboard');
            }
        }
        else{
            return view('auth/login');
        }
    }

    public function AuthLogin(Request $request)
     {
        // dd($request->all());
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
            else if (Auth::user()->user_type == 3)
            {
                return redirect('user/dashboard');
            }

        } else
        {
            return redirect()->back()->with('error','Please enter correct email address and password');
        }
    }
    function registration(){
        return view ('auth/registration');
    }

    function registrationPost(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data); 
        if(!$user){
            return redirect(route('login'))->with("success","Registration failed, try again.");
        }
        return redirect(route('login'))->with("success","Registration seccess, Login to access the app");
    }




    public function logout() {
        Auth::logout();
        return redirect(url(''));
    }
}
