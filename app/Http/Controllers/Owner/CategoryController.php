<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function category(){
        $user = Auth::user();
        if (!$user->restaurant) {
            return redirect()->back()->with('error', 'You are not associated with a restaurant.');
        }
        $category = Category::where('restaurant_id', $user->restaurant->id)->get();

        return view('owner.category.typeFood', compact('category'));
    }

    public function storeCategory(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category();
        $user = Auth::user();

        $category->name = $request->name;
        $category->restaurant_id = $user->restaurant->id;
        $category->save();
        // dd($category);
        return redirect('owner/category/typeFood')->with('success','TypeFood successfully Create');
    }

    public function editCategory(string $id)
    {
        $category = Category::findOrFail($id);
        return view('owner.category.editCategory',compact('category'));
    }

    public function updateCategory(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $user = Auth::user();

        $category->name = $request->name;
        $category->restaurant_id = $user->restaurant->id;
        $category->save();
        // dd($category);
        return redirect('owner/category/typeFood')->with('success','TypeFood successfully Updated');
    }

    public function destroyCategory(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect('owner/category/typeFood')->with('success','Category successfully Updated');
    }
}
