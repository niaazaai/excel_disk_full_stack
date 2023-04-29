<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Employee::latest()->get()); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     // 'name' => 'required|max:256',
        //     // 'father_name' => 'required|max:256', 
        //     // 'user_image' => 'mimes:png,pdf,xlx,csv,jpeg,jpg|max:2048',
        //     'user_image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        // return response()->json($request->all()); 

        
        // return response()->json($request->hasFile('user_image')); 
        $fileName = 'No File'; 
        if ($request->hasFile('user_image')) {
            $fileName = time().'.'.$request->user_image->extension(); 
            //  $request->file->move(public_path('uploads'), $fileName);
            $request->user_image->storeAs('EmployeeImages', $fileName);
        }  
       

        Employee::create([
            'name' => $request->name , 
            'father_name' => $request->father_name,
            'department' => $request->department,
            'position' => $request->position,
            'image' =>  $fileName
        ]); 
  
        return response()->json(true); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id )
    {
        $employee = Employee::findOrFail($id); 
        $employee->delete();
        return response()->json(true);
    }

    public function disable_employee(Request $request) {
        $employee = Employee::findOrFail($request->id); 
        $employee->status = 'InActive'; 
        $employee->save();
        return response()->json(true);
    }
}
