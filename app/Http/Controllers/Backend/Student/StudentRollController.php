<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignStudent;
use App\Models\User;
use App\Models\DiscountStudent;

use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use DB;
use PDF;


class StudentRollController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Manage Student Roll')->only(['StudentRollView', 'StudentRollStore']);
    }
    public function StudentRollView(Request $request)
    {
        $years = StudentYear::all();
        $classes = StudentClass::all();

        $class_id = $request->class_id;
        $year_id = $request->year_id;
        $allData = [];
        if (!empty($class_id) and !empty($year_id)) {
            $allData = AssignStudent::with(['student'])
                ->where('year_id', $request->year_id)
                ->where('class_id', $request->class_id)
                ->get();
        }
        return view('backend.student.roll_generate.roll_generate_view', compact('years','classes','class_id','year_id','allData'));
    }


    public function StudentRollStore(Request $request)
    {

        $year_id = $request->year_id;
        $class_id = $request->class_id;
        if ($request->student_id != null) {
            for ($i = 0; $i < count($request->student_id); $i++) {
                AssignStudent::where('year_id', $year_id)
                    ->where('class_id', $class_id)
                    ->where('student_id', $request->student_id[$i])
                    ->update(['roll' => $request->roll[$i]]);
            }
        } else {
            $notification = array(
                'message' => 'Sorry there are no student',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        $notification = array(
            'message' => 'Well Done Roll Generated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('roll.generate.view')->with($notification);

    }


}
