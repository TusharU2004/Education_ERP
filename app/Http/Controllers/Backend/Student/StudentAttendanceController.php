<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentAttendance;


class StudentAttendanceController extends Controller
{
   //
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
            'class_name' => $class->name,
            'total_students' => $totalStudents,
            'present_students' => $presentStudents,
            'absent_students' => $absentStudents,
            'attendance_status' => $attendanceStatus,
         ];
      }
      return view('backend.student.student_attendance.student_attendance_view', ['classReport' => $classReport]);
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

      return view('backend.student.student_attendance.student_attendance_add', [
         'studentsData' => $studentsData,
         'years' => $years,
         'classes' => $classes,
         'year_id' => $year_id,
         'class_id' => $class_id
      ]);

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
      $students = $request->students; // Contains student_id, roll, and attend_status

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
}
