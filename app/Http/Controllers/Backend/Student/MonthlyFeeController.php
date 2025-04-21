<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\AccountStudentFee;
use Illuminate\Http\Request;
use App\Models\AssignStudent;
use App\Models\User;
use App\Models\DiscountStudent;
use App\Models\FeeCategoryAmount;

use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use DB;
use PDF;


class MonthlyFeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:View Student Fee Records')->only(['MonthlyFeeView', 'MonthlyFeePayslip']);
    }

    public function MonthlyFeeView(Request $request)
    {
        $years = StudentYear::all();
        $classes = StudentClass::all();

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $month = $request->month;
        $allStudent = [];

        if (!empty($year_id) && !empty($class_id) && !empty($month)) {

            $allStudent = AssignStudent::with('discount')
                ->where('year_id', 'like', $year_id . "%")
                ->where('class_id', 'like', $class_id . "%")
                ->get();

            $selectedMonthNumber = date('m', strtotime($month));

            foreach ($allStudent as $student) {

                $monthlyFeeRecord = FeeCategoryAmount::where('fee_category_id', 2)
                    ->where('class_id', $student->class_id)
                    ->first();

                $student->monthly_fee = $monthlyFeeRecord ? $monthlyFeeRecord->amount : 0;
                $originalFee = $student->monthly_fee;

                $accountFee = AccountStudentFee::where('fee_category_id', 2)
                    ->where('year_id', 'like', $year_id)
                    ->where('class_id', 'like', $class_id)
                    ->where('student_id', 'like', $student->student_id)
                    ->whereMonth('date', $selectedMonthNumber)
                    ->first();

                if ($accountFee) {

                    $student->payment_date = $accountFee->date;
                    $student->final_fee = $accountFee->amount;

                } else {

                    $discount = $student->discount->discount;
                    $discountAmount = ($discount / 100) * $originalFee;
                    $student->final_fee = $originalFee - $discountAmount;

                }
            }
        }

        return view('backend.student.monthly_fee.monthly_fee_view',compact('years','classes','year_id','class_id','allStudent','month'));
    }



    public function MonthlyFeePayslip($encryptedData)
    {

        $data = json_decode(decrypt($encryptedData), true);

        $year_id = $data['year_id'];
        $class_id = $data['class_id'];
        $student_id = $data['student_id'];
        $month = $data['month'];


        $details = AssignStudent::with(['student', 'discount', 'student_year', 'student_class'])
            ->where('year_id', $year_id)
            ->where('student_id', $student_id)
            ->where('class_id', $class_id)
            ->first();

        $selectedMonthNumber = date('m', strtotime($month));

        $paymentRecord = AccountStudentFee::where('fee_category_id', 2)
            ->where('student_id', $student_id)
            ->whereMonth('date', $selectedMonthNumber)
            ->first();

        if ($paymentRecord) {
            $finalFee = $paymentRecord->amount;
            $payment_date = $paymentRecord->date;
        } else {

            $monthlyFeeRecord = FeeCategoryAmount::where('fee_category_id', 2)
                ->where('class_id', $class_id)
                ->first();
            $monthly_fee = $monthlyFeeRecord ? $monthlyFeeRecord->amount : 0;
            $discount = $details->discount ? $details->discount->discount : 0;
            $discountAmount = ($discount / 100) * $monthly_fee;
            $finalFee = $monthly_fee - $discountAmount;
            $payment_date = 'NOT PAID';
        }

        $pdf = PDF::loadView('backend.student.monthly_fee.monthly_fee_pdf', compact('details', 'finalFee', 'payment_date', 'month'));
        return $pdf->stream($details->student->id_no . '_monthly_receipt.pdf');

    }

}
