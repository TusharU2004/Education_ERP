<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AccountEmployeeSalary;
use App\Models\AccountOtherCost;
use App\Models\AccountStudentFee;

use PDF;

class ProfiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Profit Report');
    }
    public function MonthlyProfitView(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if ($start_date && $end_date) {
            $student_fee = AccountStudentFee::whereBetween('date', [$start_date, $end_date])->sum('amount');
            $other_cost = AccountOtherCost::whereBetween('date', [$start_date, $end_date])->sum('amount');
            $emp_salary = AccountEmployeeSalary::whereBetween('date', [$start_date, $end_date])->sum('amount');
            $total_cost = $other_cost + $emp_salary;
            $profit = $student_fee - $total_cost;
            $data = [
                'fee' => $student_fee,
                'other_cost' => $other_cost,
                'salary' => $emp_salary,
                'total_cost' => $total_cost,
                'profit' => $profit
            ];
            return view('backend.report.profit.profit_view', compact('data','start_date','end_date'));
        }
        return view('backend.report.profit.profit_view');
    }


    public function MonthlyProfitPdf(Request $request)
    {
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        $data['student_fee'] = AccountStudentFee::whereBetween('date', [$data['start_date'], $data['end_date']])->sum('amount');
        $data['other_cost'] = AccountOtherCost::whereBetween('date', [$data['start_date'], $data['end_date']])->sum('amount');
        $data['emp_salary'] = AccountEmployeeSalary::whereBetween('date', [$data['start_date'], $data['end_date']])->sum('amount');
        $data['total_cost'] = $data['other_cost'] + $data['emp_salary'];
        $data['profit'] = $data['student_fee'] - $data['total_cost'];

        $pdf = PDF::loadView('backend.report.profit.profit_pdf', $data);
        return $pdf->stream('profit_report.pdf');

    }
}
