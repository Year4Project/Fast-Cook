<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        // dd(Hash::make(12345));
        $data['header_title'] = 'Login';
        return view('auth/login',$data);

    }

    // public function AuthLogin(Request $request)
    //  {
    //    // Validation rules
    // $rules = [
    //     'email' => 'required|email',
    //     'password' => 'required',
    // ];

    // // Custom error messages
    // $messages = [
    //     'email.required' => 'The email field is required.',
    //     'email.email' => 'Please enter a valid email address.',
    //     'password.required' => 'The password field is required.',
    // ];

    // // Validate the request
    // $validator = Validator::make($request->all(), $rules, $messages);

    // // Check if the validation fails
    // if ($validator->fails()) {
    //     return redirect()
    //         ->back()
    //         ->withErrors($validator)
    //         ->withInput($request->only('email', 'remember'));
    // }

    // $data['header_title'] = 'Dashboard';

    // $remember = !empty($request->remember) ? true : false;

    // if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
    //     switch (Auth::user()->user_type) {
    //         case 1:
    //             if(isset($data['remember'])&&!empty($data['remember'])){
    //                 setcookie("email",$data['email'],time()+3600);
    //                 setcookie('password',$data['password'],time()+3600);
    //             }else{
    //                 setcookie("email","");
    //                 setcookie("password","");
    //             }
    //             return redirect('admin/dashboard');
    //         case 2:
    //             return redirect('owner/dashboard');
    //         // Add more cases for other user types if needed
    //         // case 3:
    //         //     return redirect('user/dashboard');
    //         default:
    //             return redirect('/');
    //     }
    // } else {
    //     // Authentication failed
    //     return redirect()
    //         ->back()
    //         ->withErrors(['email' => 'Invalid email or password'])
    //         ->withInput($request->only('email', 'remember'));
    // }
    // }

    public function AuthLogin(Request $request)
{
    // Validation rules
    $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    // Custom error messages
    $messages = [
        'email.required' => 'The email field is required.',
        'email.email' => 'Please enter a valid email address.',
        'password.required' => 'The password field is required.',
    ];

    // Validate the request
    $validator = Validator::make($request->all(), $rules, $messages);

    // Check if the validation fails
    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput($request->only('email', 'password', 'remember'));
    }

    // Attempt to authenticate the user
    // $remember = $request->has('remember'); // Check if "Remember Me" is checked

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
        // Authentication successful
        switch (Auth::user()->user_type) {
            case 1:
                return redirect('admin/dashboard');
            case 2:
                return redirect('owner/dashboard');
            // Add more cases for other user types if needed
            // case 3:
            //     return redirect('user/dashboard');
            default:
                return redirect('/');
        }
    } else {
        // Authentication failed
        return redirect()
            ->back()
            ->withErrors(['email' => 'Invalid email or password'])
            ->withInput($request->only('email', 'remember'));
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
