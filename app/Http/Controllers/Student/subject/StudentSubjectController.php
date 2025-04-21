<?php

namespace App\Http\Controllers\Student\subject;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\AssignSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentSubjectController extends Controller
{
   public function SubjectView(){
      $id = Auth::user()->id;
      $assign_subject = AssignStudent::with('subject.school_subject')->where('student_id',$id)->get();
      $assign_subject = $assign_subject['0']['subject'];
      return view('student.subject.view_subjects',compact('assign_subject'));
   }
}
