<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\EmployeeLeave;
use App\Models\LeavePurpose;

class EmployeeLeaveController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Manage Employee Leave');
    }
    public function LeaveView()
    {
        $allData = EmployeeLeave::orderBy('id', 'desc')->get();
        return view('backend.employee.employee_leave.employee_leave_view', compact('allData'));
    }


    public function LeaveAdd()
    {

        $employees = User::where('usertype', 'employee')->get();
        return view('backend.employee.employee_leave.employee_leave_add', compact('employees'));
    }


    public function LeaveStore(Request $request)
    {

        $request->validate([
            'reason' => 'required',
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ], [
            'employee_id.required' => 'Please Select Employee Name',
            'start_date.required' => 'Please Select Start Date',
            'end_date.required' => 'Please Select End Date'
        ]);

        $data = new EmployeeLeave();
        $data->employee_id = $request->employee_id;
        $data->start_date = date('Y-m-d', strtotime($request->start_date));
        $data->end_date = date('Y-m-d', strtotime($request->end_date));
        $data->save();

        $notification = array(
            'message' => 'Employee Leave Data Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.leave.view')->with($notification);

    }


    public function LeaveEdit($id)
    {
        $data['editData'] = EmployeeLeave::find($id);
        $data['employees'] = User::where('usertype', 'employee')->get();
        return view('backend.employee.employee_leave.employee_leave_edit', $data);

    }



    public function LeaveUpdate(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required',
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ], [
            'employee_id.required' => 'Please Select Employee Name',
            'start_date.required' => 'Please Select Start Date',
            'end_date.required' => 'Please Select End Date'
        ]);

        $data = EmployeeLeave::find($id);
        $data->employee_id = $request->employee_id;
        $data->reason = $request->reason;
        $data->start_date = date('Y-m-d', strtotime($request->start_date));
        $data->end_date = date('Y-m-d', strtotime($request->end_date));
        $data->save();

        $notification = array(
            'message' => 'Employee Leave Data Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.leave.view')->with($notification);

    }


    public function LeaveDelete($id)
    {
        $leave = EmployeeLeave::find($id);
        $leave->delete();

        $notification = array(
            'message' => 'Employee Leave Data Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.leave.view')->with($notification);
    }


}
