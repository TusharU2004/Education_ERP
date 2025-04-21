<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\AccountEmployeeSalary;
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

use App\Models\EmployeeAttendance;

class MonthlySalaryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Manage Employee Montly Salary');
    }
    public function MonthlySalaryView(Request $request)
    {
        $month = $request->month;
        if (!empty($month)) {
            $month = $request->month ?? date('m');

            $employees = User::where('usertype', 'employee')
                ->whereMonth('join_date', '<=', $month)
                ->get();
            $EmployeeData = [];

            foreach ($employees as $employee) {
                $total_working_days = EmployeeAttendance::whereMonth('date', $month)
                    ->where('employee_id', $employee->id)
                    ->count();

                $totalattend = EmployeeAttendance::whereMonth('date', $month)
                    ->where('employee_id', $employee->id)
                    ->get();

                $presentcount = count($totalattend->where('attend_status', 'Present'));
                $absentcount = count($totalattend->where('attend_status', 'Absent'));
                $totalwork = $presentcount + $absentcount;

                $salary = (float) $employee->salary;

                if ($totalwork == 0) {
                    $totalsalary = $salary;
                } else {
                    $salaryperday = $salary / $totalwork;
                    $totalsalaryminus = $absentcount * $salaryperday;
                    $totalsalary = $salary - $totalsalaryminus;
                }

                $salaryPayment = DB::table('account_employee_salaries')
                    ->where('employee_id', $employee->id)
                    ->whereMonth('date', $month)
                    ->first();

                $EmployeeData[] = [
                    'id' => $employee->id,
                    'id_no' => $employee->id_no,
                    'name' => $employee->name,
                    'lname' => $employee->lname,
                    'salary' => $salary,
                    'total_working_days' => $totalwork,
                    'present_days' => $presentcount,
                    'total_salary' => round($totalsalary),
                    'paid' => $salaryPayment ? true : false,
                    'paid_date' => $salaryPayment ? $salaryPayment->date : null,
                    'paid_amount' => $salaryPayment ? $salaryPayment->amount : null,
                    'salary_month' => $month
                ];

            }
            return view('backend.employee.monthly_salary.monthly_salary_view', compact('EmployeeData', 'month'));
        }
        return view('backend.employee.monthly_salary.monthly_salary_view');
    }


    public function MonthlySalaryPayslip($employee_id, $month)
    {
        $data['details'] = AccountEmployeeSalary::with('user')
            ->where('employee_id', $employee_id)
            ->whereMonth('date', $month)
            ->first();

        if (!$data['details']) {
            return redirect()->back()->with('error', 'Salary record not found.');
        }

        $pdf = PDF::loadView('backend.employee.monthly_salary.monthly_salary_pdf', $data);
        return $pdf->stream('salary_receipt.pdf');
    }

}
