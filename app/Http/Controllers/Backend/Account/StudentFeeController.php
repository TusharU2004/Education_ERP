<?php

namespace App\Http\Controllers\Backend\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AssignStudent;
use App\Models\FeeCategoryAmount;

use App\Models\StudentYear;
use App\Models\StudentClass;

use App\Models\AccountStudentFee;
use App\Models\FeeCategory;

class StudentFeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:School Account Management');
    }
    public function StudentFeeView()
    {
        $allData = AccountStudentFee::all();
        return view('backend.account.student_fee.student_fee_view', compact('allData'));
    }


    public function StudentFeeAdd(Request $request)
    {
        $s = AccountStudentFee::all();

        $years = StudentYear::all();
        $classes = StudentClass::all();
        $fee_categories = FeeCategory::all();

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $fee_category_id = $request->fee_category_id;

        $students = [];

        if ($year_id && $class_id && $fee_category_id) {
            $data = AssignStudent::with('discount', 'student')
                ->where('year_id', $year_id)
                ->where('class_id', $class_id)
                ->get();

            $fee = FeeCategoryAmount::where('fee_category_id', $fee_category_id)
                ->where('class_id', $class_id)
                ->first();

            foreach ($data as $std) {
                if ($fee_category_id == 1) {
                    $paid_fee = AccountStudentFee::where('student_id', $std->student_id)
                        ->where('year_id', $std->year_id)
                        ->where('class_id', $std->class_id)
                        ->where('fee_category_id', $fee_category_id)
                        ->first();
                } else {
                    $paid_fee = AccountStudentFee::where('student_id', $std->student_id)
                        ->where('year_id', $std->year_id)
                        ->where('class_id', $std->class_id)
                        ->where('fee_category_id', $fee_category_id)
                        ->whereYear('date', date('Y', strtotime($request->date)))
                        ->whereMonth('date', date('m', strtotime($request->date)))
                        ->first();
                }

                $original_fee = $fee ? $fee->amount : 0;
                $discount = $std->discount ? $std->discount->discount : 0;
                $discount_amount = ($discount / 100) * $original_fee;
                $final_fee = $original_fee - $discount_amount;

                $students[] = [
                    'id' => $std->student->id,
                    'id_no' => $std->student->id_no,
                    'name' => $std->student->fname .' '.$std->student->name.' '.$std->student->lname,
                    'original_fee' => $original_fee,
                    'discount' => $discount,
                    'final_fee' => $final_fee,
                    'description' => $paid_fee  ? $paid_fee->description : null,
                    'paid_amount' => $paid_fee ? $paid_fee->amount : null,
                    'paid_date' => $paid_fee ? $paid_fee->date : null,
                ];
            }
        }

        return view('backend.account.student_fee.student_fee_add', compact(
            'years',
            'classes',
            'fee_categories',
            'year_id',
            'class_id',
            'fee_category_id',
            'students'
        ));
    }


    public function StudentFeeStore(Request $request)
    {
        foreach ($request->id as $key => $studentId) {
            $amount = isset($request->paid_amount[$key]) ? $request->paid_amount[$key] : null;
            $date = isset($request->paid_date[$key]) ? $request->paid_date[$key] : null;
            $description = isset($request->description[$key]) ? $request->description[$key] : null;

            if (!$amount || $amount <= 0 || !$date) {
                continue;
            }

            $fee_category_id = $request->fee_category_id;
            $year_id = $request->year_id;
            $class_id = $request->class_id;

            if ($fee_category_id == 1) {
                $existingPayment = AccountStudentFee::where('student_id', $studentId)
                    ->where('fee_category_id', $fee_category_id)
                    ->first();

                if ($existingPayment) {
                    $existingPayment->amount = $amount;
                    $existingPayment->date = $date;
                    $existingPayment->description = $description;
                    $existingPayment->save();
                } else {
                    AccountStudentFee::create([
                        'student_id' => $studentId,
                        'fee_category_id' => $fee_category_id,
                        'year_id' => $year_id,
                        'class_id' => $class_id,
                        'amount' => $amount,
                        'date' => $date,
                        'description' => $description
                    ]);
                }
            } elseif ($fee_category_id == 2) {

                $existingPayment = AccountStudentFee::where('student_id', $studentId)
                    ->where('fee_category_id', $fee_category_id)
                    ->where('year_id', $year_id)
                    ->where('class_id', $class_id)
                    ->whereMonth('date', date('m', strtotime($date)))
                    ->whereYear('date', date('Y', strtotime($date)))
                    ->first();

                if ($existingPayment) {
                    $existingPayment->amount = $amount;
                    $existingPayment->date = $date;
                    $existingPayment->description = $description;
                    $existingPayment->save();
                } else {
                    AccountStudentFee::create([
                        'student_id' => $studentId,
                        'fee_category_id' => $fee_category_id,
                        'year_id' => $year_id,
                        'class_id' => $class_id,
                        'amount' => $amount,
                        'date' => $date,
                        'description'=>$description
                    ]);
                }
            }
        }

        $notification = array(
            'message' => 'Well Done! Data Successfully Updated',
            'alert-type' => 'success'
        );

        return redirect()->route('student.fee.view')->with($notification);
    }


}
