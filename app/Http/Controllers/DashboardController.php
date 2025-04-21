<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\Account\AccountSalaryController;
use App\Models\AccountEmployeeSalary;
use App\Models\AccountOtherCost;
use App\Models\AccountStudentFee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->usertype === 'Student') {
            return redirect()->route('student.dashboard');
        } else {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $student = User::where('usertype', 'student')->count();
            $staff = User::where('usertype', 'employee')->count();

            $employeeSalary = AccountEmployeeSalary::whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->sum('amount');

            $otherCost = AccountOtherCost::whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->sum('amount');

            $fee = AccountStudentFee::whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->sum('amount');

            $profit = $fee - $employeeSalary - $otherCost;

            return view('admin.index', compact('student', 'staff', 'profit','otherCost'));
        }

    }
}
