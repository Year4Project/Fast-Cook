<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OwnerController extends Controller
{
    public function index(){
        $user = Auth::user();
        $menu = Menu::where("restaurant_id", $user->id)->orderBy('id','asc')->get();

        return view('owner.food.index',compact('menu'));
    }
    public function create(){
        $menu = Menu::all();
        return view('owner.food.create',compact('menu'));
    }

    public function store(Request $request){
        // dd($request->all());
        // $restaurant = new Restaurant();
        $menu = new Menu;
        

            $menu->name=$request->name;

            if(!empty($request->file('image'))) {
                $ext = $request->file('image')->getClientOriginalExtension();
                $file = $request->file('image');
                $randomStr = date('Ymdhis').Str::random(20);
                $filename = strtolower($randomStr).'.'.$ext;
                $file->move('upload/food/', $filename);
    
                $menu->image = $filename;
            }
            $menu->oPrice=$request->oPrice;
            $menu->dPrice=$request->dPrice;
            $menu->restaurant_id = Auth::user()->id;
            $menu->save();

            return redirect('owner/food/index')->with('success', "Food successfully Create.");
    }

    public function updateStatus($id){
        $getStatus = Menu::select('status')->where('restaurant_id',$id)->first();
        if($getStatus->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        Menu::where('restaurant_id',$id)->update(['status'=>$status]);
        return redirect('owner/food/showRestaurant')->with('success', "status successfully update.");
    }

    public function edit($id){
        $menu = Order::findOrFail($id);
        if(!empty($data))
        {
            $menu['getOrderUser'] = Order::getOrderUser($id);
            $menu['header_titles'] = "Edit Order";
            return view('owner/food/edit',compact('menu'));
        }
        else
        {
            abort(404);
        }

        
    }

    public function update(Request $request, $id){

        $menu = Menu::findOrFail($id);
        
        // $image=$request->image;

        // $imagename = time().'.'.$image->getClientOriginalExtension();

        //     $request->image->move('foodimage', $imagename);

            $menu->name=$request->name;

            if(!empty($request->file('image'))) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/food/', $filename);

            $menu->image = $filename;
        }
            
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
