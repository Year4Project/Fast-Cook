<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';
        if (Auth::user()->user_type == 1)
            {
                return view('admin.dashboard',$data);

            } else if (Auth::user()->user_type == 2)
            {
                return view('owner.dashboard',$data);

            } else if (Auth::user()->user_type == 3)
            {
                return view('user.dashboard',$data);

            } 
    }
}
