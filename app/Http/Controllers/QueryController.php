<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\Select;

class QueryController extends Controller
{
    function query()
    {
        $subQuery = DB::table('student_marks')
            ->select(
                'student_id',
                DB::raw('SUM(marks) as total_marks'),
                DB::raw('COUNT(*) as subject_count'),
                DB::raw('ROUND((SUM(marks)/(COUNT(*)*100)) * 100, 2) as percentage'),
                DB::raw("
                    CASE
                        WHEN (SUM(marks) / (COUNT(*)*100)) * 100 >= 90 THEN 'A+'
                        WHEN (SUM(marks) / (COUNT(*)*100)) * 100 >= 80 THEN 'A'
                        WHEN (SUM(marks) / (COUNT(*)*100)) * 100 >= 70 THEN 'B+'
                        WHEN (SUM(marks) / (COUNT(*)*100)) * 100 >= 60 THEN 'B'
                        WHEN (SUM(marks) / (COUNT(*)*100)) * 100 >= 50 THEN 'C+'
                        WHEN (SUM(marks) / (COUNT(*)*100)) * 100 >= 40 THEN 'C'
                        ELSE 'F'
                    END as grade
                ")
            )
            ->groupBy('student_id');

        $data = DB::table('users')->join('student_marks', 'users.id', '=', 'student_marks.student_id')
            ->join('school_subjects', 'school_subjects.id', '=', 'student_marks.assign_subject_id')
            ->join('exam_types', 'exam_types.id', '=', 'student_marks.exam_type_id')
            ->join('student_classes', 'student_classes.id', '=', 'student_marks.student_id')
            ->joinSub($subQuery, 'totals', function ($join) {
                $join->on('users.id', '=', 'totals.student_id');
            })
            ->select(
                'users.name as StudentName',
                'student_classes.name as ClassName',
                'exam_types.name as Exam',
                'school_subjects.name as Subject',
                'student_marks.marks as Mark',
                'totals.total_marks as TotalMarks',
                'totals.percentage as Percentage',
                'totals.grade as Grade',
            )
            ->get()->groupBy('StudentName');

        $subQuery = DB::table('account_student_fees')->where('fee_category_id',1)
                    ->select('student_id',
                        DB::raw('SUM(amount) as TotalAmount')
                    )
                    ->groupBy('student_id');

        $data = DB::table('account_student_fees')->join('users','users.id','=','account_student_fees.student_id')
                ->join('fee_categories','fee_categories.id','=','account_student_fees.fee_category_id')
                ->join('student_classes','student_classes.id','=','account_student_fees.class_id')
                ->joinSub($subQuery,'totals',function($join){
                    $join->on('users.id','=','totals.student_id');
                })
                ->Select(
                    'users.name as Name',
                    'fee_categories.name as Fee Category',
                    'account_student_fees.amount',
                    'account_student_fees.date',
                    'account_student_fees.description as Mode',
                    'student_classes.name as Class Name',
                    'TotalAmount'
                )
                ->get()
                ->groupBy('Name');

        return $data;
    }
}