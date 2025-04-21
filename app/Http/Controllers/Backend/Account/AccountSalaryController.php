<?php

namespace App\Http\Controllers\Backend\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\EmployeeAttendance;

use App\Models\AccountEmployeeSalary;

class AccountSalaryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:School Account Management');
    }
    public function AccountSalaryView()
    {
        $allData = AccountEmployeeSalary::all();
        return view('backend.account.employee_salary.employee_salary_view', compact('allData'));
    }


    public function AccountSalaryAdd(Request $request)
    {
        $month = $request->month;

        if (!empty($month)) {
            $year = date('Y', strtotime($month));
            $month = date('m', strtotime($month));

          
            $data = EmployeeAttendance::select('employee_id')
                ->groupBy('employee_id')
                ->with(['user'])
                ->whereMonth('date',$month)
                ->get();
                
            $allEmployees = User::where('usertype', 'employee')
                ->whereMonth('join_date', '<=', $month)
                ->whereYear('join_date','<=',$year)
                ->get();

                $employees = [];

            foreach ($allEmployees as $employee) {

                $attend = $data->where('employee_id', $employee->id)->first();

                $account_salary = AccountEmployeeSalary::where('employee_id', $employee->id)
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->first();

                    $totalattend = EmployeeAttendance::whereYear('date','=',$year)
                    ->whereMonth('date','=',$month)
                    ->where('employee_id', $employee->id)
                    ->get();

                $presentcount = count($totalattend->where('attend_status', 'Present'));
                $absentcount = count($totalattend->where('attend_status', 'Absent'));

                $salary = (float) $employee->salary;

                $totalwork = $presentcount + $absentcount;

                if ($totalwork == 0) {
                    $totalsalary = $salary;
                } else {
                    $salaryperday = $salary / $totalwork;
                    $totalsalaryminus = $absentcount * $salaryperday;
                    $totalsalary = (int) ($salary - $totalsalaryminus);
                }

                $employees[] = [
                    'id' => $employee->id,
                    'id_no' => $employee->id_no,
                    'name' => $employee->name,
                    'salary' => $employee->salary,
                    'totalwork' => $totalwork,
                    'absent' => $absentcount,
                    'totalsalary' => $totalsalary,
                    'paid' => $account_salary ? true : false,
                    'paid_date' => $account_salary ? $account_salary->date : null,
                    'paid_amount' => $account_salary ? $account_salary->amount : null
                ];
            }
            return view('backend.account.employee_salary.employee_salary_add', compact('employees', 'month'));
        }
        return view('backend.account.employee_salary.employee_salary_add');
    }


    public function AccountSalaryStore(Request $request)
    {

        foreach ($request->employee_id as $employeeId) {

            if (empty($request->salary_date[$employeeId])) {
                continue;
            }

            $salaryMonth = date('Y-m', strtotime($request->salary_date[$employeeId]));

            $existingSalary = AccountEmployeeSalary::where('employee_id', $employeeId)
                ->where('date', 'like', $salaryMonth . '%')
                ->first();

            if ($existingSalary) {
                $existingSalary->update([
                    'amount' => $request->totalsalary[$employeeId],
                    'date' => $request->salary_date[$employeeId]
                ]);
            } else {
                AccountEmployeeSalary::create([
                    'employee_id' => $employeeId,
                    'date' => $request->salary_date[$employeeId],
                    'amount' => $request->totalsalary[$employeeId],
                ]);
            }

        }

        $notification = array(
            'message' => 'Well Done Data Successfully Updated',
            'alert-type' => 'success'
        );

        return redirect()->route('account.salary.view')->with($notification);

    }

}
