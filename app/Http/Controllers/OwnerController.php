<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function listMenu(){
        $menu = Food::all();
        return view('owner.listMenu',compact('menu'));
    }

    public function addFood(){
        return view('owner.addFood');
    }
    
    public function insertFood(Request $request)
    {
        // dd($request->all());
        $menu = new Food();;
        
        $image=$request->image;

        $imagename = time().'.'.$image->getClientOriginalExtension();

            $request->image->move('foodimage', $imagename);

            $menu->name=$request->name;
            $menu->code=$request->code;
            $menu->oPrice=$request->oPrice;
            $menu->dPrice=$request->dPrice;
            $menu->image=$imagename;
            $menu->stock=$request->stock;
            $menu->save();

            return redirect('owner/listMenu')->with('success', "Food successfully add to list.");
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Food::find($id);
        return view('owner.editFood',compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $menu=Food::find($id);

        $image=$request->image;
        
        $imagename = time().'.'.$image->getClientOriginalExtension();

            $request->image->move('foodimage', $imagename);

            $menu->name=$request->name;
            $menu->code=$request->code;
            $menu->oPrice=$request->oPrice;
            $menu->dPrice=$request->dPrice;
            $menu->image=$imagename;
            $menu->stock=$request->stock;
            $menu->save();


            return redirect('owner/listMenu')->with('success', "Food successfully update.");

    }

     /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $menu=Food::find($id);

        $menu->delete();

        return redirect()->back();
    }

    public function qrCode(){
        return view('owner.generateQRCode');
    }
}
