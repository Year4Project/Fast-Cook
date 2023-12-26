<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile($id){
        $user = User::findOrFail($id)->first();
        return view('owner.profile.profile',compact('user'));
    }
}
