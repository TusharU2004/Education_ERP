<?php

namespace App\Http\Controllers\student\timetable;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use Auth;
use Illuminate\Http\Request;

class StudentClassTimeTable extends Controller
{
   public function TimeTableView()
   {

      $id = Auth::user()->id;

      $data = AssignStudent::with('timetable.subject')->where('student_id', $id)->first();

      if (!$data) {
         return view('student.timetable.timetable_view')->with('timetable', []);
      }

      $timetable = [];
      foreach ($data->timetable as $entry) {
         $timetable[$entry->day][$entry->start_time] = $entry;
      }

      return view('student.timetable.timetable_view', compact('timetable'));

   }
}
