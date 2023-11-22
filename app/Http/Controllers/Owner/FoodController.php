<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showFood()
    {
        $user = Auth::user();
        $foods = Food::where("restaurant_id", $user->id)->orderBy('id','asc')->get();
        
            return view('owner.food.showFood',compact('foods'));
        
    }

    /**
     * Show the form for creating a new resource.
     */

     public function createFood(){

    return view('owner.food.createFood');
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeFood(Request $request)
    {
        $food = new Food();
        
        $food->name = $request->name;
        $food->description = $request->description;
        
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
            $food->restaurant_id= Auth::user()->id;
            $food->save();
            // $restaurant->foods()->save($food);
        
            return redirect('owner/food/showFood')->with('success', "Food successfully Create.");
    }

    public function updateStatus($id){
        $getStatus = Food::select('status')->where('id',$id)->first();
        if($getStatus->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        Food::where('id',$id)->update(['status'=>$status]);
        return redirect('admin/admin/showAdmin')->with('success', "status successfully update.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['getRecord'] = Food::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['header_title'] = "Edit Admin";
            return view('owner.food.edit', $data);
        }
        else
        {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required|string',
            'oPrice' => 'required',
            'dPrice' => 'required',
        ]);

        $food = Food::getSingle($id);
        
        $food->name = $request->name;
        $food->description = $request->description;
        
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
            $food->restaurant_id= Auth::user()->id;
            $food->save();
            // $restaurant->foods()->save($food);
        
            return redirect('owner/food/showFood')->with('success', "Food successfully Update.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
