<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class Food extends Model
{
    use HasFactory;
    protected $table = 'foods';
    protected $fillable = [
        'restaurant_id',
        'name',
        'code',
        'price',
        'description',
        'image',
        'status',
    ];

    protected static function boot(){
        parent::boot();
        self::creating(function ($food){
            $getFood = self::orderBy('code','desc')->first();
            if ($getFood){
                $lastestID = intval(substr($getFood->code,3));
                $nextID = $lastestID + 1;
            } else {
                $nextID = 1;
            }
            $food->code = 'KHF_'.sprintf("%03s",$nextID);
            while(self::where('code',$food->code)->exists()) {
                $nextID++;
                $food->code = 'KHF_' . sprintf("%03s", $nextID);
            }
        });
    }


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'food_id', 'id');
    }

    public function order()
    {
        return $this->belongsToMany(Order::class, 'food_order')->withPivot('quantity');
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getFood()
    {
        $user = Auth::user();

        if (!$user->restaurant) {
            // Handle the case where the user is not associated with a restaurant
            return redirect()->back()->with('error', 'You are not associated with a restaurant.');
        }
        $foods = Food::where('restaurant_id', $user->restaurant->id)->get();

        return $foods;
    }

    public function delete()
    {
        // Delete the associated image when deleting the Food record
        $this->deleteImage();

        // Call the parent delete method
        parent::delete();
    }

    protected function deleteImage()
    {
        // Check if the image file exists
        if ($this->image) {
            $imagePath = public_path('upload/food/') . $this->image;

            // Delete the image file
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
    }
}
