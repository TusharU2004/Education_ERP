<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Twilio\Rest\Client;
use App\Models\User;



class StudentAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Manage Student Attendence');
    }
    public function AttendanceView()
    {
        $classes = StudentClass::all();

        $classReport = [];

        foreach ($classes as $class) {

            $totalStudents = AssignStudent::where('class_id', $class->id)->count();

            $presentStudents = StudentAttendance::where('class_id', $class->id)
                ->where('date', '=', date('Y-m-d'))
                ->where('attend_status', 'Present')
                ->count();

            $absentStudents = StudentAttendance::where('class_id', $class->id)
                ->where('date', date('Y-m-d'))
                ->where('attend_status', 'Absent')
                ->count();

            if ($presentStudents + $absentStudents < $totalStudents) {
                $attendanceStatus = 'Pending';
            } else {
                $attendanceStatus = 'Completed';
            }

            $classReport[] = [
                'class_id' => $class->id,
                'class_name' => $class->name,
                'total_students' => $totalStudents,
                'present_students' => $presentStudents,
                'absent_students' => $absentStudents,
                'attendance_status' => $attendanceStatus,
            ];
        }
        return view('backend.student.student_attendance.student_attendance_view', compact('classReport'));
    }


    public function AttendanceAdd()
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        return view('backend.student.student_attendance.student_attendance_add', $data);
    }


    public function getStudentdetails(Request $request)
    {
        $years = StudentYear::all();
        $classes = StudentClass::all();
        $year_id = $request->year_id;
        $class_id = $request->class_id;

        $students = AssignStudent::with('student')
            ->where('year_id', $year_id)
            ->where('class_id', $class_id)
            ->get();

        $studentsData = $students->map(function ($attendance) {
            return [
                'student_id' => $attendance->student_id,
                'roll' => $attendance->roll,
                'class_id' => $attendance->class_id,
                'year_id' => $attendance->year_id,
                'name' => $attendance->student->name,
                'lname' => $attendance->student->lname,
            ];
        });

        return view('backend.student.student_attendance.student_attendance_add', compact('studentsData','years','classes','year_id','class_id'));

    }


    public function AttendanceStore(Request $request)
    {
        $request->validate([
            'year_id' => 'required|integer',
            'class_id' => 'required|integer',
            'date' => 'required|date',
            'students' => 'required|array',
        ]);

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $date = $request->date;
        $students = $request->students;

        foreach ($students as $studentId => $data) {
            StudentAttendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $date,
                ],
                [
                    'year_id' => $year_id,
                    'class_id' => $class_id,
                    'roll' => $data['roll'] ?? null,
                    'attend_status' => $data['attend_status'] ?? 'Absent',
                ]
            );
        }

        $notification = array(
            'message' => 'Student Attendace Data Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.attendance.view')->with($notification);
    }

    public function sendDailyAttendanceWhatsApp(Request $request)
    {

        $request->validate([
            'class_id' => 'required'
        ]);

        $classId = $request->class_id;
        $today = Carbon::today()->toDateString(); // e.g., '2025-02-25'

        $attendances = StudentAttendance::with('student')
            ->where('class_id', $classId)
            ->whereDate('date', $today)
            ->get();

        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $whatsappFrom = config('services.twilio.whatsapp_from');

        $client = new Client($sid, $token);

        foreach ($attendances as $attendance) {

            $status = $attendance->attend_status;
            $mobile = $attendance->student->student->mobile;
            $whatsappTo = "whatsapp:" . '+91' . $mobile;

            $messageContent = "Dear Parent, your child " . $attendance->student->name . " was marked as " . $status . " on " . Carbon::parse($attendance->date)->format('d-m-Y') . ".";

            try {
                $client->messages->create(
                    $whatsappTo,
                    [
                        'from' => $whatsappFrom,
                        'body' => $messageContent,
                    ]
                );
            } catch (\Exception $e) {
                $notification = array(
                    'message' => 'Error to sent attendance data' . $e->getMessage(),
                    'alert-type' => 'error'
                );

                return redirect()->route('student.attendance.view')->with($notification);
            }
        }
        $notification = array(
            'message' => 'Student Attendance Data sent Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('student.attendance.view')->with($notification);
    }
}


