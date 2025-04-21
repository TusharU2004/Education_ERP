<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\StudentMarks;
use App\Models\ExamType;
use App\Models\StudentClass;
use App\Models\StudentYear;
use App\Models\MarksGrade;
use PDF;
use PhpParser\Node\Expr\Assign;


class MarkSheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Generate Marksheet');
    }

    public function MarkSheetView(Request $request)
    {

        $years = StudentYear::all();
        $classes = StudentClass::all();
        $exam_type = ExamType::all();

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $exam_type_id = $request->exam_type_id;

        $allStudent = [];
        if ($year_id && $class_id && $exam_type_id) {
            $allStudent = AssignStudent::where('year_id', $year_id)
                ->where('class_id', $class_id)
                ->orderBy('roll')
                ->get();
        }
        return view('backend.report.marksheet.marksheet_view', compact('years','classes','exam_type','allStudent','year_id','class_id','exam_type_id'));

    }


    public function MarkSheetGet(Request $request)
    {

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $exam_type_id = $request->exam_type_id;
        $id_no = $request->id_no;

        $data = StudentMarks::with('school_subject', 'assign_subject', 'year', 'student_class', 'exam_type')
            ->where('year_id', $year_id)
            ->where('class_id', $class_id)
            ->where('exam_type_id', $exam_type_id)
            ->where('id_no', $id_no)
            ->get();

        $student = User::where('usertype', 'student')
            ->where('id_no', $id_no)
            ->first();
        if (!empty($data)) {
            $students = [
                'id_no' => $student->id_no,
                'name' => $student->lname . " " . $student->name . " " . $student->fname,
                'class' => $data[0]['student_class']['name'],
                'year' => $data[0]['year']['name'],
                'exam' => $data[0]['exam_type']['name']
            ];
            foreach ($data as $key => $student) {
                $marks[] = [
                    'subject' => $student->school_subject->name,
                    'totalmarks' => $student->assign_subject->full_mark,
                    'marks' => $student->marks
                ];
            }
            $pdf = PDF::loadView('backend.report.marksheet.marksheet_pdf', compact('students', 'marks'));
            return $pdf->stream($student->id_no.'.pdf');
        } else {
            $notification = array(
                'message' => 'Marks not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

}
