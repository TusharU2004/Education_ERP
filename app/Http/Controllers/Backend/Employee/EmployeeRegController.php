<?php

namespace App\Http\Controllers\Backend\Employee;

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

use App\Models\Designation;
use App\Models\EmployeeSallaryLog;

class EmployeeRegController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Manage Employee Registration');
    }


    public function EmployeeView()
    {
        $allData = User::where('usertype', 'Employee')->get();
        return view('backend.employee.employee_reg.employee_view', compact('allData'));
    }


    public function EmployeeAdd()
    {
        $designation = Designation::all();
        return view('backend.employee.employee_reg.employee_add', compact('designation'));
    }


    public function EmployeeStore(Request $request)
    {

        $request->validate([
            'name' => 'required|alpha',
            'fname' => 'required|alpha',
            'lname' => 'required|alpha',
            'mobile' => 'required|regex:/[6-9]{1}[0-9]{9}/',
            'address' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'designation_id' => 'required',
            'salary' => 'required|numeric',
            'join_date' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp'
        ], [
            'gender.required' => 'Please Select Gender',
            'dob.required' => 'Please Select Date of Birth',
            'designation_id.required' => 'Please Select Designation Name',
            'join_date.required' => 'Please Select Join Date'
        ]);
        $checkYear = date('Y', strtotime($request->join_date));

        $lastEmployee = User::where('usertype', 'employee')->orderBy('id', 'DESC')->first();

        $employeeId = $lastEmployee ? $lastEmployee->id + 1 : 1;
        $id_no = str_pad($employeeId, 4, '0', STR_PAD_LEFT);

        $final_id_no = $checkYear . $id_no;

        $shortYear = date('y', strtotime($checkYear));
        $email = strtolower(substr($request->name, 0, 1) . substr($request->fname, 0, 1) 
                . substr($request->lname, 0, 1)) . $shortYear . '@demo.ac.in';

        $user = new User();
        $user->id_no = $final_id_no;
        $user->password = bcrypt(date('dmY', strtotime($request->dob)));
        $user->usertype = 'employee';
        $user->email = $email;
        $user->code = rand(0000, 9999);
        $user->name = $request->name;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->religion = $request->religion;
        $user->salary = $request->salary;
        $user->designation_id = $request->designation_id;
        $user->dob = date('Y-m-d', strtotime($request->dob));
        $user->join_date = date('Y-m-d', strtotime($request->join_date));

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/employee_images'), $filename);
            $user['image'] = $filename;
        }
        $user->save();

        $employee_salary = new EmployeeSallaryLog();
        $employee_salary->employee_id = $user->id;
        $employee_salary->effected_salary = date('Y-m-d', strtotime($request->join_date));
        $employee_salary->previous_salary = $request->salary;
        $employee_salary->present_salary = $request->salary;
        $employee_salary->increment_salary = '0';
        $employee_salary->save();


        $notification = array(
            'message' => 'Employee Registration Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.registration.view')->with($notification);

    }


    public function EmployeeEdit($id)
    {
        $editData = User::find($id);
        $designation = Designation::all();

        return view('backend.employee.employee_reg.employee_edit', compact('editData', 'designation'));

    }


    public function EmployeeUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->mobile = $request->mobile;
        $user->password = bcrypt(date('dmY', strtotime($request->dob)));
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->religion = $request->religion;

        $user->designation_id = $request->designation_id;
        $user->dob = date('Y-m-d', strtotime($request->dob));


        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/employee_images/' . $user->image));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/employee_images'), $filename);
            $user['image'] = $filename;
        }
        $user->save();

        $notification = array(
            'message' => 'Employee Registration Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.registration.view')->with($notification);

    }


    public function EmployeeDetails($id)
    {
        $details = User::find($id);

        $pdf = PDF::loadView('backend.employee.employee_reg.employee_details_pdf', compact('details'));
        return $pdf->stream('document.pdf');

    }


}