<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentShift;

class StudentShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Manage Shifts')->only([
            'ViewShift',
            'StudentShiftAdd',
            'StudentShiftStore',
            'StudentShiftEdit',
            'StudentShiftUpdate',
            'StudentShiftDelete'
        ]);
    }
    public function ViewShift()
    {
        $allData = StudentShift::all();
        return view('backend.setup.shift.view_shift', compact('allData'));
    }

    public function StudentShiftAdd()
    {
        return view('backend.setup.shift.add_shift');
    }


    public function StudentShiftStore(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:student_shifts,name',
        ]);

        $data = new StudentShift();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Shift Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.shift.view')->with($notification);

    }



    public function StudentShiftEdit($id)
    {
        $editData = StudentShift::find($id);
        return view('backend.setup.shift.edit_shift', compact('editData'));

    }

    public function StudentShiftUpdate(Request $request, $id)
    {

        $data = StudentShift::find($id);
        $request->validate([
            'name' => 'required|unique:student_shifts,name,' . $data->id

        ]);

        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Shift Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.shift.view')->with($notification);
    }


    public function StudentShiftDelete($id)
    {
        $shift = StudentShift::find($id);
        $shift->delete();

        $notification = array(
            'message' => 'Student Shift Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('student.shift.view')->with($notification);

    }

}
