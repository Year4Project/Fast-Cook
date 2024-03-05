<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function foods()
{
    return $this->belongsToMany(Food::class);
}

    public static function getCategories(){
        $user = Auth::user();
        if (!$user->restaurant) {
            return redirect()->back()->with('error', 'You are not associated with a restaurant.');
        }
        $category = Category::where('restaurant_id', $user->restaurant->id)->paginate(5);

        return $category;
    }
}
