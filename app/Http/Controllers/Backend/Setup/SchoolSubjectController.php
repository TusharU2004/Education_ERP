<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolSubject;

class SchoolSubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Manage School Subjects')->only([
            'ViewSubject',
            'SubjectAdd',
            'SubjectStore',
            'SubjectEdit',
            'SubjectUpdate',
            'SubjectDelete'
        ]);
    }


    public function ViewSubject()
    {
        $allData = SchoolSubject::all();
        return view('backend.setup.school_subject.view_school_subject',compact('allData'));
    }


    public function SubjectAdd()
    {
        return view('backend.setup.school_subject.add_school_subject');
    }

    public function SubjectStore(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:school_subjects,name',
        ]);

        $data = new SchoolSubject();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Subject Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('school.subject.view')->with($notification);

    }


    public function SubjectEdit($id)
    {
        $editData = SchoolSubject::find($id);
        return view('backend.setup.school_subject.edit_school_subject', compact('editData'));
    }



    public function SubjectUpdate(Request $request, $id)
    {

        $data = SchoolSubject::find($id);

        $request->validate([
            'name' => 'required|unique:school_subjects,name,' . $data->id

        ]);

        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Subject Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('school.subject.view')->with($notification);
    }


    public function SubjectDelete($id)
    {
        $subject = SchoolSubject::find($id);
        $subject->delete();

        $notification = array(
            'message' => 'Subject Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('school.subject.view')->with($notification);

    }

}
