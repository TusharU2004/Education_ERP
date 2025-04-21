<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\StudentClass;
use App\Models\StudentYear;
use Illuminate\Http\Request;
use PDF;

class StudentIDController extends Controller
{

    public function IdcardView(Request $request)
    {
        $years = StudentYear::all();
        $classes = StudentClass::all();

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        $allStudent = [];
        if (!empty($year_id) and !empty($class_id)) {
            $allStudent = AssignStudent::where('year_id', $year_id)
                ->where('class_id', $class_id)
                ->get();
        }

        return view('backend.report.idcard.idcard_view', compact('years','classes','year_id','class_id','allStudent'));
    }


    public function IdcardGenrate(Request $request, $id_no, $id)
    {

        $student = AssignStudent::where('student_id', $id)
            ->first();

        $pdf = PDF::loadView('backend.report.idcard.idcard_pdf', compact('student'));
        return $pdf->stream('document.pdf');


    }
}
