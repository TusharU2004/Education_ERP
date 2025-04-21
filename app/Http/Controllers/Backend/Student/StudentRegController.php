<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignStudent;
use App\Models\User;
use App\Models\DiscountStudent;

use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use DB;
use PDF;

class StudentRegController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Manage Student Registration');
    }
    public function StudentRegView(Request $request)
    {
        $years = StudentYear::all();
        $classes = StudentClass::all();

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $allData = [];
        if (!empty($year_id) and !empty($class_id)) {
            $allData = AssignStudent::with('student')
                ->where('year_id', $year_id)
                ->where('class_id', $class_id)
                ->whereHas('student', function ($query) {
                    $query->where('status', 1);
                })
                ->get();
        }
        return view('backend.student.student_reg.student_view', compact('years', 'classes', 'year_id', 'class_id', 'allData'));

    }

    public function StudentRegAdd()
    {
        $years = StudentYear::all();
        $classes = StudentClass::all();
        $groups = StudentGroup::all();
        $shifts = StudentShift::all();
        return view('backend.student.student_reg.student_add', compact('years', 'classes', 'groups', 'shifts'));
    }


    public function StudentRegStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'mobile' => 'required|regex:/[6-9]{1}[0-9]{9}/',
            'address' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'discount' => 'required|numeric|min:0|max:100',
            'year_id' => 'required',
            'class_id' => 'required',
            'shift_id' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp'
        ], [
            'fname.required' => 'The Father name is required.',
            'lname.required' => 'The Last name is required.',
            'mobile.required' => 'The Mobile number is required.',
            'mobile.regex' => 'Enter valid Mobile number.',
            'dob.required' => 'The Date of Birth is required.',
            'year_id.required' => 'Select current year.',
            'class_id.required' => 'Select Student Class.',
            'shift_id.required' => 'Select Student Shift.'
        ]);


        $checkYear = StudentYear::findOrFail($request->year_id)->name;

        $lastStudent = User::where('usertype', 'Student')->orderBy('id', 'DESC')->first();

        $studentId = $lastStudent ? $lastStudent->id + 1 : 1;
        $id_no = str_pad($studentId, 4, '0', STR_PAD_LEFT);

        $final_id_no = $checkYear . $id_no;

        $shortYear = date('y', strtotime($checkYear));

        $email = strtolower($request->name . $request->lname . $shortYear . '@demo.ac.in');
        $code = rand(1000, 9999);

        $user = new User();
        $user->id_no = $final_id_no;
        $user->email = $email;
        $user->password = bcrypt(date('dmY', strtotime($request->dob)));
        $user->usertype = 'Student';
        $user->code = $code;
        $user->name = $request->name;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->religion = $request->religion;
        $user->dob = date('Y-m-d', strtotime($request->dob));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/student_images'), $filename);
            $user->image = $filename;
        }
        $user->save();

        $assignStudent = new AssignStudent();
        $assignStudent->student_id = $user->id;
        $assignStudent->year_id = $request->year_id;
        $assignStudent->class_id = $request->class_id;
        $assignStudent->group_id = $request->group_id;
        $assignStudent->shift_id = $request->shift_id;
        $assignStudent->save();

        $discountStudent = new DiscountStudent();
        $discountStudent->assign_student_id = $assignStudent->id;
        $discountStudent->fee_category_id = '2';
        $discountStudent->discount = $request->discount;
        $discountStudent->save();

        $notification = array(
            'message' => 'Student Registration Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.registration.view')->with($notification);

    }


    public function StudentRegEdit($student_id)
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['groups'] = StudentGroup::all();
        $data['shifts'] = StudentShift::all();

        $data['editData'] = AssignStudent::with(['student', 'discount'])->where('student_id', $student_id)->first();

        return view('backend.student.student_reg.student_edit', $data);

    }


    public function StudentRegUpdate(Request $request, $student_id)
    {
        DB::transaction(function () use ($request, $student_id) {

            $user = User::where('id', $student_id)->first();
            $user->name = $request->name;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->mobile = $request->mobile;
            $user->password = bcrypt(date('dmY', strtotime($request->dob)));
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->religion = $request->religion;
            $user->dob = date('Y-m-d', strtotime($request->dob));

            if ($request->file('image')) {
                $file = $request->file('image');
                @unlink(public_path('upload/student_images/' . $user->image));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/student_images'), $filename);
                $user['image'] = $filename;
            }
            $user->save();

            $assign_student = AssignStudent::where('id', $request->id)->where('student_id', $student_id)->first();

            $assign_student->year_id = $request->year_id;
            $assign_student->class_id = $request->class_id;
            $assign_student->group_id = $request->group_id;
            $assign_student->shift_id = $request->shift_id;
            $assign_student->save();

            $discount_student = DiscountStudent::where('assign_student_id', $request->id)->first();

            $discount_student->discount = $request->discount;
            $discount_student->save();

        });


        $notification = array(
            'message' => 'Student Registration Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.registration.view')->with($notification);

    }


    public function StudentRegDetails($student_id)
    {
        $data['details'] = AssignStudent::with(['student', 'discount'])->where('student_id', $student_id)->first();
        $pdf = PDF::loadView('backend.student.student_reg.student_details_pdf', $data);
        return $pdf->stream($data['details']->student->id_no . '.pdf');

    }


    public function StudentInactive($student_id)
    {
        $status = User::where('id', $student_id)
            ->update(['status' => 0]);

        if ($status) {

            $notification = [
                'message' => 'Student Has been Inactive Successfully',
                'alert-type' => 'success'
            ];
        } else {
            $notification = [
                'message' => 'Student not found or update failed',
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('student.registration.view')->with($notification);
    }



}