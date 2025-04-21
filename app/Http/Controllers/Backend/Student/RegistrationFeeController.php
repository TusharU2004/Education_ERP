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
use Illuminate\Support\Facades\Storage;
use PDF;
use Twilio\Rest\Client;


class RegistrationFeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Student Fee Records')->only(['RegFeeView', 'RegFeePayslip']);
    }
    public function RegFeeView(Request $request)
    {
        $years = StudentYear::all();
        $classes = StudentClass::all();

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $allStudent = [];
        if (!empty($year_id) and !empty($class_id)) {
            $allStudent = AssignStudent::with('discount')
                ->where('year_id', 'like', $year_id . "%")
                ->where('class_id', 'like', $class_id . "%")
                ->orderBy('roll', 'asc')
                ->get();

            foreach ($allStudent as $student) {
                $registrationFee = FeeCategoryAmount::where('fee_category_id', 1)
                    ->where('class_id', $student->class_id)
                    ->first();

                $student->registration_fee = $registrationFee ? $registrationFee->amount : 0;
                $accountFee = AccountStudentFee::where('fee_category_id', 1)
                    ->where('year_id', 'like', $year_id)
                    ->where('class_id', 'like', $class_id)
                    ->where('student_id', 'like', $student->student_id)
                    ->first();

                if ($accountFee) {
                    $student->payment_date = $accountFee->date;
                    $student->final_fee = $accountFee->amount;
                } else {
                    $discount = $student->discount->discount;
                    $discountAmount = ($discount / 100) * $student->registration_fee;
                    $student->final_fee = $student->registration_fee - $discountAmount;
                }
            }
        }
        return view('backend.student.registration_fee.registration_fee_view', compact('years', 'classes', 'year_id', 'class_id', 'allStudent'));
    }


    public function RegFeePayslip(Request $request)
    {
        $student_id = $request->student_id;
        $class_id = $request->class_id;

        $details = AssignStudent::with(['student', 'discount', 'student_year', 'student_class'])
            ->where('student_id', $student_id)
            ->first();

        $accountFee = AccountStudentFee::where('fee_category_id', 1)
            ->where('student_id', $student_id)
            ->first();

        if ($accountFee) {

            $finalfee = $accountFee->amount;
            $details->payment_date = $accountFee->date;
        } else {

            $registrationFee = FeeCategoryAmount::where('fee_category_id', 1)
                ->where('class_id', $details->class_id)
                ->first();
            $originalfee = $registrationFee ? $registrationFee->amount : 0;
            $discount = $details->discount->discount;
            $discountAmount = ($discount / 100) * $originalfee;
            $finalfee = $originalfee - $discountAmount;
            $details->payment_date = 'NOT PAID';
        }

        $pdf = PDF::loadView('backend.student.registration_fee.registration_fee_pdf', compact('details', 'finalfee'));
        return $pdf->stream($details->student->id_no . '_receipt.pdf');

    }


    public function generateAndSendReceipt(Request $request)
    {
        $student_id = $request->student_id;
        $class_id = $request->class_id;


        $details = AssignStudent::with(['student', 'discount', 'student_year', 'student_class'])
            ->where('student_id', $student_id)
            ->first();

        $accountFee = AccountStudentFee::where('fee_category_id', 1)
            ->where('student_id', $student_id)
            ->first();

        if ($accountFee) {
            $finalfee = $accountFee->amount;
            $details->payment_date = $accountFee->date;
        } else {
            $registrationFee = FeeCategoryAmount::where('fee_category_id', 1)
                ->where('class_id', $details->class_id)
                ->first();
            $originalfee = $registrationFee ? $registrationFee->amount : 0;
            $discount = $details->discount->discount;
            $discountAmount = ($discount / 100) * $originalfee;
            $finalfee = $originalfee - $discountAmount;
            $details->payment_date = 'NOT PAID';
        }

        $pdf = Pdf::loadView('backend.student.registration_fee.registration_fee_pdf', compact('details', 'finalfee'));
        $filename = 'receipt_' . time() . '.pdf';

        Storage::disk('public')->put("temp_receipts/{$filename}", $pdf->output());
        $publicUrl = asset("storage/temp_receipts/{$filename}");

        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $twilio = new Client($sid, $token);

        $phone = preg_replace('/\D/', '', $details->student->mobile);

        $to = 'whatsapp:+91' . $details->student->mobile;
        $from = 'whatsapp:+14155238886';

        $twilio->messages->create($to, [
            'from' => $from,
            'body' => "Hello {$details->student->name}, here is your receipt.",
            'mediaUrl' => ["https://drive.google.com/uc?export=download&id=1WFEkQZGj7qcLFqdqkzxeBxCiVZ8SS0It"]
        ]);

        sleep(4);
        $notification = array(
            'message' => 'The receipt has been sent successfully on WhatsApp',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }


}
