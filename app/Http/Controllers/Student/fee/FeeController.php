<?php

namespace App\Http\Controllers\student\fee;

use App\Http\Controllers\Controller;
use App\Models\AccountStudentFee;
use App\Models\AssignStudent;
use App\Models\DiscountStudent;
use App\Models\FeeCategory;
use App\Models\FeeCategoryAmount;
use Auth;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function RegistrationView()
    {
        $id = Auth::user()->id;

        $student = AssignStudent::where('student_id', $id)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        $year_id = $student->year_id;
        $class_id = $student->class_id;

        $registration_fee = FeeCategoryAmount::where('class_id', $class_id)
            ->where('fee_category_id', 1)
            ->first();

        $registration_fee_paid = AccountStudentFee::where('student_id', $id)
            ->where('year_id', $year_id)
            ->where('class_id', $class_id)
            ->where('fee_category_id', 1)
            ->exists();

            $final_registration_fee = $registration_fee_paid ? $registration_fee->amount : ($registration_fee->amount ?? 0);

        $total_fee = $final_registration_fee;

        return view('student.fee.registration_fee', compact('student', 'final_registration_fee', 'total_fee', 'registration_fee_paid'));

    }

    public function MonthlyFeeView()
    {

        $id = Auth::user()->id;

        $student = AssignStudent::where('student_id', $id)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        $year_id = $student->year_id;
        $class_id = $student->class_id;

        $monthly_fee = FeeCategoryAmount::where('class_id', $class_id)
            ->where('fee_category_id', 2)
            ->first();

        $discount = DiscountStudent::where('assign_student_id', $student->id)
            ->where('fee_category_id', 2)
            ->first();

        $discount_percentage = $discount ? $discount->discount : 0;
        $final_monthly_fee = $monthly_fee ? ($monthly_fee->amount - ($monthly_fee->amount * ($discount_percentage / 100))) : 0;

        $paid_months = AccountStudentFee::where('student_id', $id)
            ->where('year_id', $year_id)
            ->where('class_id', $class_id)
            ->where('fee_category_id', 2)
            ->get()
            ->map(function ($record) {
                return \Carbon\Carbon::parse($record->date)->month;
            })
            ->toArray();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = [
                'month_number' => $i,
                'month_name' => \Carbon\Carbon::create()->month($i)->format('F'),
                'is_paid' => in_array($i, $paid_months),
                'fee' => $final_monthly_fee
            ];
        }

        return view('student.fee.monthly_fee', compact('months'));

    }
}