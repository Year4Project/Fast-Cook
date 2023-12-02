<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(){
        $data['header_title'] = 'Chat';
        return view('owner.chat.chat',$data);
    }
}
