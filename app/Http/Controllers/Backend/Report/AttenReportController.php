<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\StudentAttendance;
use App\Models\StudentClass;
use App\Models\StudentYear;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\EmployeeAttendance;
use PDF;

class AttenReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Employee Attendance Report')->only([
            'employeeAttenReportView',
            'employeeAttenReportGet'
        ]);

        $this->middleware('permission:Stduent Attendance Report')->only([
            'studentAttenReportView',
            'studentAttenReportGet'
        ]);
    }
    public function employeeAttenReportView()
    {
        $employees = User::where('usertype', 'employee')->get();
        return view('backend.report.attend_report.attend_report_view', compact('employees'));
    }


    // public function employeeAttenReportGet(Request $request){
    //     $request->validate([
    //         'date' => 'required|date_format:Y-m',
    //     ]);

    //     $month = $request->date;
    //     $employees = User::where('usertype', 'employee')->get();

    //     $attendanceRecords = EmployeeAttendance::where('date', 'like', $month . '%')->get();

    //     $employeeAttendanceData = [];

    //     foreach ($employees as $employee) {
    //         $attendanceArray = [];

    //         for ($day = 1; $day <= 31; $day++) {
    //             $date = date('Y-m-d', strtotime($month . '-' . $day));
    //             $dayOfWeek = date('N', strtotime($date)); // 7 = Sunday

    //             $attendance = $attendanceRecords->where('employee_id', $employee->id)
    //                 ->where('date', $date)
    //                 ->first();

    //             if ($attendance) {
    //                 if ($attendance->attend_status == 'Present') {
    //                     $status = 'P';
    //                 } elseif ($attendance->attend_status == 'Absent') {
    //                     $status = 'A';
    //                 } else {
    //                     $status = '-';
    //                 }
    //             } else {
    //                 if ($dayOfWeek == 7) {
    //                     $status = 'H'; // Sunday & no record => Holiday
    //                 } else {
    //                     $status = '-'; // Working day but no attendance marked
    //                 }
    //             }

    //             $attendanceArray[$day] = $status;
    //         }

    //         $employeeAttendanceData[] = [
    //             'employee' => $employee,
    //             'attendance' => $attendanceArray,
    //         ];
    //     }

    //     $data = [
    //         'employeeAttendanceData' => $employeeAttendanceData,
    //         'month' => date('F Y', strtotime($month)),
    //     ];
    //     $pdf = PDF::loadView('backend.report.attend_report.attend_report_pdf', $data);
    //     return $pdf->stream('employee_attendance_report.pdf');

    // }

    public function employeeAttenReportGet(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m',
        ]);

        $month = $request->date;
        $employees = User::where('usertype', 'employee')->get();

        $attendanceRecords = EmployeeAttendance::where('date', 'like', $month . '%')->get();

        $graphData = [];

        foreach ($employees as $employee) {
            $present = 0;
            $absent = 0;
            $holiday = 0;

            for ($day = 1; $day <= 31; $day++) {
                $date = date('Y-m-d', strtotime($month . '-' . $day));
                $dayOfWeek = date('N', strtotime($date));

                $attendance = $attendanceRecords->where('employee_id', $employee->id)
                    ->where('date', $date)
                    ->first();

                if ($attendance) {
                    if ($attendance->attend_status == 'Present') {
                        $present++;
                    } elseif ($attendance->attend_status == 'Absent') {
                        $absent++;
                    }
                } else {
                    if ($dayOfWeek == 7) {
                        $holiday++;
                    }
                }
            }

            $graphData[] = [
                'name' => ($employee->lname.' '.$employee->name),
                'present' => $present,
                'absent' => $absent,
                'holiday' => $holiday,
            ];
        }
        $data = [
            'graphData' => $graphData,
            'month' => date('F Y', strtotime($month)),
        ];
        return view('backend.report.attend_report.attend_report_view', $data);
    }


    public function studentAttenReportView()
    {
        $classes = StudentClass::all();

        return view('backend.report.attend_report.student_attend_report_view', ['classes' => $classes]);
    }

    // public function studentAttenReportGet(Request $request)
    // {
    //     $request->validate([
    //         'class_id' => 'required',
    //         'date' => 'required|date',
    //     ]);

    //     $class_id = $request->class_id;
    //     $month = date('Y-m', strtotime($request->date));

    //     $students = AssignStudent::with('student')
    //         ->where('class_id', $class_id)
    //         ->orderBy('roll', 'asc')
    //         ->get();

    //     $attendanceRecords = StudentAttendance::where('class_id', $class_id)
    //         ->where('date', 'like', $month . '%')
    //         ->get();

    //     $studentAttendanceData = [];
    //     foreach ($students as $assignStudent) {
    //         $attendanceArray = [];

    //         for ($day = 1; $day <= 31; $day++) {
    //             $date = date('Y-m-d', strtotime($month . '-' . $day));
    //             $isSunday = (date('N', strtotime($date)) == 7);

    //             $attendance = $attendanceRecords->where('student_id', $assignStudent->student_id)
    //                 ->where('date', $date)
    //                 ->first();

    //             if ($isSunday) {
    //                 $status = 'H';
    //             } elseif ($attendance && $attendance->attend_status == 'Present') {
    //                 $status = 'P';
    //             } elseif ($attendance && $attendance->attend_status == 'Absent') {
    //                 $status = 'A';
    //             } else {
    //                 $status = '-';
    //             }

    //             $attendanceArray[$day] = $status;
    //         }

    //         $studentAttendanceData[] = [
    //             'roll_no' => $assignStudent->roll,
    //             'name' => $assignStudent->student->name,
    //             'lname' => $assignStudent->student->lname,
    //             'fname' => $assignStudent->student->fname,
    //             'attendance' => $attendanceArray
    //         ];
    //     }
    //     if (empty($studentAttendanceData)) {
    //         return redirect()->back()->with([
    //             'message' => 'No attendance records found for this class.',
    //             'alert-type' => 'error',
    //         ]);
    //     }

    //     $data = [
    //         'studentAttendanceData' => $studentAttendanceData,
    //         'class' => StudentClass::find($class_id),
    //         'month' => date('F Y', strtotime($request->date)),
    //     ];

    //     $pdf = PDF::loadView('backend.report.attend_report.student_attend_report_pdf', $data);
    //     return $pdf->stream('class_attendance_report.pdf');

    //}

    public function studentAttenReportGet(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'date' => 'required|date',
        ]);

        $classes = StudentClass::all();
        $class_id = $request->class_id;
        $month = date('Y-m', strtotime($request->date));

        $students = AssignStudent::with('student')
            ->where('class_id', $class_id)
            ->orderBy('roll', 'asc')
            ->get();

        $attendanceRecords = StudentAttendance::where('class_id', $class_id)
            ->where('date', 'like', $month . '%')
            ->get();

        $studentAttendanceData = [];
        $graphData = [];

        foreach ($students as $assignStudent) {
            $attendanceArray = [];
            $present = 0;
            $absent = 0;
            $holiday = 0;

            for ($day = 1; $day <= 31; $day++) {
                $date = date('Y-m-d', strtotime($month . '-' . $day));
                $isSunday = (date('N', strtotime($date)) == 7);

                $attendance = $attendanceRecords->where('student_id', $assignStudent->student_id)
                    ->where('date', $date)
                    ->first();

                if ($isSunday) {
                    $status = 'H';
                    $holiday++;
                } elseif ($attendance && $attendance->attend_status == 'Present') {
                    $status = 'P';
                    $present++;
                } elseif ($attendance && $attendance->attend_status == 'Absent') {
                    $status = 'A';
                    $absent++;
                } else {
                    $status = '-';
                }

                $attendanceArray[$day] = $status;
            }

            // $studentAttendanceData[] = [
            //     'roll_no' => $assignStudent->roll,
            //     'name' => $assignStudent->student->name,
            //     'lname' => $assignStudent->student->lname,
            //     'fname' => $assignStudent->student->fname,
            //     'attendance' => $attendanceArray
            // ];

            $graphData[] = [
                'name' => $assignStudent->student->name . ' ' . $assignStudent->student->lname,
                'present' => $present,
                'absent' => $absent,
                'holiday' => $holiday,
            ];
        }

        $data = [
            // 'studentAttendanceData' => $studentAttendanceData,
            'graphData' => $graphData,
            'month' => date('F Y', strtotime($request->date)),
            'classes' => $classes,
            'class_id' => $class_id
        ];
        return view('backend.report.attend_report.student_attend_report_view', $data);

    }
}
