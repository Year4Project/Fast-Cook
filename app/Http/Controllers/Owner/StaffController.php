<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listStaff()
    {
        return view('owner/staff/listStaff');
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
        $staff->save();

        return redirect('owner/staff/listStaff')->with('success', "Staff successfully Create.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
