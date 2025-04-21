<?php

namespace App\Http\Controllers\Student\fee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\Models\AccountStudentFee;
use App\Models\AssignStudent;

class PaymentController extends Controller
{

    public function initiatePayment(Request $request)
    {
        $user = Auth::user();

        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

        $month = $request->month;
        $amount = $request->amount; 
        $finalAmount = $amount * 100;

        $order = $api->order->create([
            'receipt' => 'receipt_' . uniqid(),
            'amount' => $finalAmount,
            'currency' => 'INR'
        ]);

        Session::put('payment_data', [
            'month' => $month,
            'amount' => $amount,
            'order_id' => $order['id']
        ]);

        return view('student.fee.razorpay', [
            'order_id' => $order['id'],
            'amount' => $finalAmount,
            'user' => $user,
            'month' => $month
        ]);
    }


    public function paymentSuccess(Request $request)
    {
        $user = Auth::user();
        $data = Session::get('payment_data');

        AccountStudentFee::create([
            'student_id' => $user->id,
            'class_id' => AssignStudent::where('student_id', $user->id)->value('class_id'),
            'year_id' => AssignStudent::where('student_id', $user->id)->value('year_id'),
            'fee_category_id' => 2,
            'date' => Carbon::create(null, $data['month'], 1),
            'amount' => $data['amount'],
            'description' => 'OnlineMonthly Fee',
            'transaction_id' => $request->razorpay_payment_id,
        ]);

        Session::forget('payment_data');
        return response()->json(['status' => 'success']);
    }


    function viewReceipt($month)
    {

        $user = Auth::user();

        $details = AssignStudent::with('student')->where('student_id', $user->id)->first();

        $fee = AccountStudentFee::where('student_id', $user->id)
            ->whereMonth('date', $month)
            ->first();

        if (!$fee) {
            abort(404, 'Receipt not found.');
        }

        $pdf = PDF::loadView(
            'student.fee.invoice',
            compact('details', 'month', 'fee')
        );

        return $pdf->stream('receipt_' . now()->format('Ym-d-His') . '.pdf');

    }
}
