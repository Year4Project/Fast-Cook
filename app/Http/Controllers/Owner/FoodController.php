<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
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

        $data['getFood'] = Food::getFood();
        $data['header_title'] = 'List Food';
        // $categories = Category::with('products')->get();

        return view('owner.food.showFood', $data);
    }

    /**
     * Show the form for creating a new resource.
     */

     public function createFood()
     {
         $user = Auth::user();

         if (!$user->restaurant) {
             return redirect()->back()->with('error', 'You are not associated with a restaurant.');
         }

         $categories = Category::where('restaurant_id', $user->restaurant->id)->get();

         return view('owner.food.createFood', ['categories' => $categories]);
     }





    /**
     * Store a newly created resource in storage.
     */
    public function storeFood(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        $food = new Food();
        $user = Auth::user();

        if (!$user->restaurant) {
            // Handle the case where the user is not associated with a restaurant
            return redirect()->back()->with('error', 'You are not associated with a restaurant.');
        }

        $food->name = $request->name;
        $food->description = $request->description;

        if (!empty($request->file('image'))) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename =     strtolower($randomStr) . '.' . $ext;

            // Move the uploaded image to the specified directory
            $file->move(public_path('upload/food/'), $filename);

            // Generate the image URL
            $imageUrl = url('upload/food/' . $filename);
            $food->image_url = $imageUrl;
        }

        $food->price = $request->price;

        $food->restaurant_id = $user->restaurant->id;


        $food->save();
        return redirect('owner/food/showFood')->with('success', "Food successfully Create.");
    }

    public function updateStatus($id)
    {
        try {
            // Fetch the food item by ID
            $food = Food::findOrFail($id);

            // Toggle the status (assuming 'status' is a boolean field)
            $food->status = !$food->status;

            // Save the updated status
            $food->save();

            return redirect('owner/food/showFood')->with('success', 'Status successfully updated.');
        } catch (\Exception $e) {
            // Log the exception
            // \Log::error('Exception during status update: ' . $e->getMessage());

            // Handle the exception as needed
            return redirect()->back()->with('error', 'An error occurred during status update.');
        }
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
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Admin";
            return view('owner.food.edit', $data);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
        ]);

        $food = Food::getSingle($id);
        $user = Auth::user();

        $food->name = $request->name;
        $food->description = $request->description;

        if (!empty($request->file('image'))) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;

            // Move the uploaded image to the specified directory
            $file->move(public_path('upload/food/'), $filename);

            $food->image = $filename;

            // Generate the image URL
            $imageUrl = url('upload/food/' . $filename);
            $food->image_url = $imageUrl;
        }

        $food->price = $request->price;

        $food->restaurant_id = $user->restaurant->id;
        $food->save();

        return redirect('owner/food/showFood')->with('success', "Food successfully Update.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $food = Food::findOrFail($id);
        $food->delete();
        return redirect('owner/food/showFood')->with('success', "Food successfully Delete.");
    }
}
