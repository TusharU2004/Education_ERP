<?php

namespace App\Http\Controllers\student\exam;

use App\Http\Controllers\Controller;
use App\Models\ExamType;
use App\Models\StudentMarks;
use Auth;
use Illuminate\Http\Request;

class StudentResultController extends Controller
{
   public function ResultView(Request $request){
      $id = Auth::user()->id;
      $exams = ExamType::all();
      $exam_id = $request->exam;
      if($exam_id){
         $students = StudentMarks::with('school_subject','exam_type','assign_subject')
                        ->where('student_id',$id)
                        ->where('exam_type_id',$exam_id)
                        ->get();

        $totalObtainedMarks = $students->sum('marks'); // Sum of obtained marks
        $totalFullMarks = $students->sum(function($student) {
            return $student->assign_subject->full_mark;
        });

        $percentage = ($totalFullMarks > 0) ? round(($totalObtainedMarks * 100) / $totalFullMarks, 2) : 0;

        return view('student.exam.exam_result_view', compact('students', 'exams', 'exam_id', 'totalObtainedMarks', 'totalFullMarks', 'percentage'));
      }
      return view('student.exam.exam_result_view',compact('exams'));
   }
}
