<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staff';
    protected $fillable = [
        'restaurant_id',
        'name',
        'phone',
        'age',
        'gender',
        'image',
        'position',
    ];

    static public function getSingle($id)
    {
        return self::find($id);
    }
    public function getProfile()
    {
        if(!empty($this->image) && file_exists('upload/staff/'.$this->image)) {
            return url('upload/staff/'.$this->image);
        } else {
            return "";
        }
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    static public function getStaff()
    {
        $user = Auth::user();
        $restaurant = $user->restaurant->id;
        $staff = Staff::with('restaurant')->where('restaurant_id', $restaurant)->get();
        // dd($staff);
        return $staff;
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
            $imagePath = public_path('upload/staff/') . $this->image;

            // Delete the image file
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
    }




}
