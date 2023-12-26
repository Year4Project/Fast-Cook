<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listStaff()
    {
        $data['getStaff'] = Staff::getStaff();
        $data['header_title'] = 'List Staff';
        // $user = Auth::user();
        // $staff = Staff::where("restaurant_id", $user->id)->orderBy('id','asc')->get();
        return view('owner/staff/listStaff',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createStaff()
    {
        return view('owner/staff/createStaff');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeStaff(Request $request)
    {
        $staff = new Staff();

        $staff->name = $request->name;
        $staff->phone = $request->phone;
        $staff->age = $request->age;
        $staff->gender = $request->gender;
        $staff->position = $request->position;
        $staff->restaurant_id= Auth::user()->restaurant->id;

        if(!empty($request->file('image'))) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/staff/', $filename);

            $staff->image = $filename;
        }

        $staff->save();

        return redirect('owner/staff/listStaff')->with('success', "Staff successfully Create.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['getStaff'] = Staff::getSingle($id);
        if(!empty($data['getStaff']))
        {
            $data['header_title'] = "Edit Admin";
            return view('owner.staff.editStaff',$data);
        }
        else
        {
            abort(404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStaff(Request $request, string $id)
    {

        $staff = Staff::getSingle($id);

        $staff->name = $request->name;
        $staff->phone = $request->phone;
        $staff->age = $request->age;
        $staff->gender = $request->gender;
        $staff->position = $request->position;
        $staff->restaurant_id= Auth::user()->restaurant->id;

        if(!empty($request->file('image'))) {
            if (!empty($staff->getProfile()))
            {
                unlink('upload/staff/'. $staff->image);
            }
            $ext = $request->file('image')->getClientOriginalExtension();
            $file = $request->file('image');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/staff/', $filename);

            $staff->image = $filename;
        }

        $staff->save();

        return redirect('owner/staff/listStaff')->with('success', "Staff successfully Update.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();
        return redirect('owner/staff/listStaff')->with('success', "Staff successfully Delete.");
    }
}
