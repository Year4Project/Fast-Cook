<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function category(){

        $data["getCategories"] = Category::getCategories();

        return view('owner.category.typeFood', $data);
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

    public function updateStatus($id)
    {
        $getStatus = Category::select('status')->where('id', $id)->first();
        if ($getStatus->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        Category::where('id', $id)->update(['status' => $status]);
        return redirect('owner/category/typeFood')->with('success', "status successfully update.");
    }
}
