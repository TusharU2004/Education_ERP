<?php

namespace App\Http\Controllers\Backend\Marks;

use App\Http\Controllers\Controller;
use App\Models\AssignSubject;
use Illuminate\Http\Request;
use App\Models\AssignStudent;
use App\Models\User;
use App\Models\DiscountStudent;

use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use PDF;

use App\Models\StudentMarks;
use App\Models\ExamType;

class MarksController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Marks Entry')->only(['MarksAdd', 'MarksStore']);
        $this->middleware('permission:Marks View')->only('MarksView');
    }
    public function MarksAdd(Request $request)
    {
        $years = StudentYear::all();
        $classes = StudentClass::all();
        $exam_types = ExamType::all();

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $exam_type_id = $request->exam_type_id;
        $assign_subject_id = $request->assign_subject_id;

        if ($year_id && $class_id && $exam_type_id && $assign_subject_id) {

            $year_id = $request->year_id;
            $class_id = $request->class_id;
            $exam_type_id = $request->exam_type_id;
            $assign_subject_id = $request->assign_subject_id;

            $students = AssignStudent::with('student')
                ->where('year_id', $year_id)
                ->where('class_id', $class_id)
                ->get();

            $studentMarks = StudentMarks::where('year_id', $year_id)
                ->where('class_id', $class_id)
                ->where('assign_subject_id', $assign_subject_id)
                ->where('exam_type_id', $exam_type_id)
                ->get()
                ->keyBy('student_id');

            $totalmarks = AssignSubject::where('class_id', $class_id)
                ->where('subject_id', $assign_subject_id)
                ->select('full_mark')
                ->first();

            return view('backend.marks.marks_add', compact('students','totalmarks','studentMarks','years','classes','exam_types','year_id','class_id','exam_type_id','assign_subject_id'));
        }

        return view('backend.marks.marks_add', compact('years','classes','exam_types'));

    }



    public function MarksStore(Request $request)
    {
        $id_no = $request->id_no;
        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $exam_type_id = $request->exam_type_id;
        $assign_subject_id = $request->assign_subject_id;
        $student_ids = $request->student_id;
        $marks = $request->marks;

        foreach ($student_ids as $key => $student_id) {

            if (!isset($marks[$key]) || trim($marks[$key]) === '') {
                continue;
            }

            $studentMark = StudentMarks::where([
                'student_id' => $student_id,
                'year_id' => $year_id,
                'class_id' => $class_id,
                'exam_type_id' => $exam_type_id,
                'assign_subject_id' => $assign_subject_id,
            ])->first();

            if ($studentMark) {
                $studentMark->update([
                    'marks' => $marks[$key],
                    'id_no' => $id_no[$key]
                ]);

            } else {
                StudentMarks::create([
                    'student_id' => $student_id,
                    'id_no' => $id_no[$key],
                    'year_id' => $year_id,
                    'class_id' => $class_id,
                    'assign_subject_id' => $assign_subject_id,
                    'exam_type_id' => $exam_type_id,
                    'marks' => $marks[$key]
                ]);
            }
        }

        $notification = array(
            'message' => 'Student Marks Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('marks.entry.add')->with($notification);

    }


    public function MarksView(Request $request)
    {

        $years = StudentYear::all();
        $classes = StudentClass::all();
        $exam_types = ExamType::all();

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $exam_type_id = $request->exam_type_id;

        if (!$year_id || !$class_id || !$exam_type_id) {
            return view('backend.marks.marks_view', compact('years', 'classes', 'exam_types'));
        }

        $students = StudentMarks::with(['student', 'school_subject'])
            ->where(compact('year_id', 'class_id', 'exam_type_id'))
            ->get()
            ->groupBy('student_id')
            ->map(function ($marks, $student_id) {
                $totalMarks = $marks->sum('marks');
                $totalSubjects = $marks->count();
                return [
                    'student_id' => $student_id,
                    'student_name' => $marks->first()->student->name,
                    'roll' => $marks->first()->student->roll,
                    'id_no' => $marks->first()->student->id_no,
                    'marks' => $marks,
                    'total_marks' => $totalMarks,
                    'percentage' => $totalSubjects ? ($totalMarks / ($totalSubjects * 100)) * 100 : 0
                ];
            })
            ->values()
            ->sortByDesc('total_marks')
            ->map(function ($student, $rank) {
                $student['rank'] = $rank + 1;
                return $student;
            });
        return view('backend.marks.marks_view', compact('students', 'years', 'classes', 'exam_types', 'year_id', 'class_id', 'exam_type_id'));
    }



}
