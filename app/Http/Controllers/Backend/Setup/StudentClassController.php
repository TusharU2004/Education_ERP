<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentClass;

class StudentClassController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Manage Classes')->only(['ViewStudent', 'StudentClassAdd', 'StudentClassStore', 'StudentClassEdit', 'StudentClassUpdate', 'StudentClassDelete']);
    }

    public function ViewStudent()
    {
        $allData = StudentClass::all();
        return view('backend.setup.student_class.view_class',compact('allData'));

    }


    public function StudentClassAdd()
    {
        return view('backend.setup.student_class.add_class');
    }


    public function StudentClassStore(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:student_classes,name',

        ]);

        $data = new StudentClass();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Class Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.class.view')->with($notification);

    }


    public function StudentClassEdit($id)
    {
        $editData = StudentClass::find($id);
        return view('backend.setup.student_class.edit_class', compact('editData'));

    }


    public function StudentClassUpdate(Request $request, $id)
    {

        $data = StudentClass::find($id);

        $request->validate([
            'name' => 'required|unique:student_classes,name,' . $data->id

        ]);


        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Student Class Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.class.view')->with($notification);
    }


    public function StudentClassDelete($id)
    {
        $class = StudentClass::find($id);
        $class->delete();

        $notification = array(
            'message' => 'Student Class Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('student.class.view')->with($notification);

    }

}
