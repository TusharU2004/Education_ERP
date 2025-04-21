<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Models\Student; // Adjust the namespace as needed

class WhatsAppController extends Controller
{
    /**
     * Send a WhatsApp message using Twilio API and redirect back.
     */
    public function sendWhatsAppMessage(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'student_id' => 'required|integer',
            'message' => 'required|string'
        ]);

        // Retrieve student details (assuming phone is stored in the student model)
        $student = User::findOrFail($request->student_id);

        // Get Twilio credentials from config
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $whatsappFrom = config('services.twilio.whatsapp_from'); // e.g., "whatsapp:+14155238886"

        // Prepare the recipient phone number in international format
        // Ensure that the phone number in the database includes the country code
        $phone = preg_replace('/\D/', '', $student->mobile);
        $whatsappTo = "whatsapp:" . '+91' . $phone;

        // Prepare the message text
        $messageContent = $request->message;

        // Create a new Twilio client instance and send the message
        $client = new Client($sid, $token);

        try {
            $messageResponse = $client->messages->create(
                $whatsappTo,
                [
                    'from' => $whatsappFrom,
                    'body' => $messageContent,
                ]
            );
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Error sending WhatsApp message: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $notification = array(
            'message' => 'WhatsApp message sent successfully! (Message SID: ' . $messageResponse->sid . ')',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function create()
    {
        return view('backend.notification.create');
    }
    public function sendNotification(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $whatsappFrom = config('services.twilio.whatsapp_from');

        $client = new Client($sid, $token);
        $messageContent = $request->message;

        $users = User::all('mobile');
        $successCount = 0;
        $failCount = 0;
        $failedNumbers = [];
        foreach ($users as $user) {
            $mobile = preg_replace('/\D/', '', $user->mobile);
            $whatsappTo = "whatsapp:" . '+91' . $mobile;

            try {
                $messageResponse = $client->messages->create(
                    $whatsappTo,
                    [
                        'from' => $whatsappFrom,
                        'body' => $messageContent,
                    ]
                );
                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
                $failedNumbers[] = $user->mobile;
            }
        }
        $notification = [
            'message' => "WhatsApp messages sent: $successCount successful, $failCount failed.",
            'alert-type' => $failCount > 0 ? 'warning' : 'success'
        ];

        if ($failCount > 0) {
            $notification['message'] .= ' Failed numbers: ' . implode(', ', $failedNumbers);
        }

        return redirect()->back()->with($notification);


    }

}
