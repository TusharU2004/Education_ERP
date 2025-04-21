<?php

namespace App\Http\Controllers\Student\attendance;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class StudentAttendance extends Controller
{
   
   public function AttendanceView(){
      $id = Auth::user()->id;
      $attendance = \App\Models\StudentAttendance::where('student_id',$id)->orderBy('date','desc')->get();
      $totalWork = $attendance->whereIn('attend_status',['Present','Absent'])->count();
      $present = $attendance->where('attend_status','Present')->count();
      $percentage = round($present*100/$totalWork);
      return view('student.attendance.view_attendance',compact('attendance','percentage'));
   }
}
