<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function index(){
        $menu = Menu::all();
        return view('owner.food.index',compact('menu'));
    }
    public function create(){
        $menu = Menu::all();
        return view('owner.food.create',compact('menu'));
    }

    public function store(Request $request){
        // dd($request->all());
        $menu = new Menu;
        
        $image=$request->image;

        $imagename = time().'.'.$image->getClientOriginalExtension();

            $request->image->move('foodimage', $imagename);

            $menu->name=$request->name;
            $menu->code=$request->code;
            $menu->image=$imagename;
            $menu->oPrice=$request->oPrice;
            $menu->dPrice=$request->dPrice;
            $menu->restaurant_id = Auth::user()->id;
            $menu->save();

            return redirect('owner/food/index')->with('success', "Food successfully Create.");
    }

    public function edit($id){
        $menu = Menu::findOrFail($id);
        return view('owner/food/edit',compact('menu'));
    }

    public function update(Request $request, $id){

        $menu = Menu::findOrFail($id);
        
        $image=$request->image;

        $imagename = time().'.'.$image->getClientOriginalExtension();

            $request->image->move('foodimage', $imagename);

            $menu->name=$request->name;
            $menu->code=$request->code;
            $menu->image=$imagename;
            $menu->oPrice=$request->oPrice;
            $menu->dPrice=$request->dPrice;
            $menu->restaurant_id = Auth::user()->id;
            $menu->save();

            return redirect('owner/food/index')->with('success', "Food successfully update.");
    }

    public function delete($id) // Function to delete a user from the admin
    {
        $menu = Menu::find(request()->id);
        $menu->delete();

        return redirect('owner/food/index')->with('success', "Food successfully delete.");
    }
}
