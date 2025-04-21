<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentYear;

class StudentYearController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Manage Years')->only(['ViewYear', 'StudentYearAdd', 'StudentYearStore', 'StudentYearEdit', 'StudentYearUpdate', 'StudentYearDelete']);
    }

    public function ViewYear()
    {
        $allData = StudentYear::all();
        return view('backend.setup.year.view_year', compact('allData'));

    }


    public function StudentYearAdd()
    {
        return view('backend.setup.year.add_year');
    }

    public function StudentYearStore(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:student_years,name',
        ]);

        $data = new StudentYear();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Year Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.year.view')->with($notification);

    }


    public function StudentYearEdit($id)
    {
        $editData = StudentYear::find($id);
        return view('backend.setup.year.edit_year', compact('editData'));

    }


    public function StudentYearUpdate(Request $request, $id)
    {

        $data = StudentYear::find($id);

        $request->validate([
            'name' => 'required|unique:student_years,name,' . $data->id
        ]);

        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Year Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.year.view')->with($notification);
    }



    public function StudentYearDelete($id)
    {
        $year = StudentYear::find($id);
        $year->delete();

        $notification = array(
            'message' => 'Student Year Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('student.year.view')->with($notification);

    }



}
