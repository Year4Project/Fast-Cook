<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OwnerController extends Controller
{
    public function index(){
    //    $data['getRestauran'] = Restaurant::getRestaurant();
    //    $data['getFood'] = Food::getFood();
    //    $data['header_title'] = 'List Food';
        return view('owner.food.index');
    }
    public function create($id){
        $restaurant = Restaurant::find($id);
        return view('owner.food.create',compact('restaurant'));
    }

    public function storeFood(Request $request, $restaurant_id){
       
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $food = new Food;
        $food->name = $validatedData['name'];
        $food->description = $validatedData['description'];
        $food->restaurant_id = $restaurant_id;

            if(!empty($request->file('image'))) {
                $ext = $request->file('image')->getClientOriginalExtension();
                $file = $request->file('image');
                $randomStr = date('Ymdhis').Str::random(20);
                $filename = strtolower($randomStr).'.'.$ext;
                $file->move('upload/food/', $filename);
    
                $food->image = $filename;
            }
            $food->oPrice=$request->oPrice;
            $food->dPrice=$request->dPrice;

            $food->save();

            
            return redirect()->route('owner.food.index', $restaurant_id)->with('success', "Food successfully Create.");
    }

    public function updateStatus($id){
        $getStatus = Food::select('status')->where('restaurant_id',$id)->first();
        if($getStatus->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        Food::where('restaurant_id',$id)->update(['status'=>$status]);
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

        $menu = Food::findOrFail($id);

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
        $menu = Food::find(request()->id);
        $menu->delete();

        return redirect('owner/food/index')->with('success', "Food successfully delete.");
    }

}
