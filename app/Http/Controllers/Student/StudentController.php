<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AccountStudentFee;
use App\Models\AssignStudent;
use App\Models\AssignSubject;
use App\Models\StudentAttendance;
use App\Models\StudentMarks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $studentId = Auth::user()->id;

        $totalPaid = AccountStudentFee::where('student_id', $studentId)->sum('amount');

        $currentMonth = Carbon::now()->month;
        $totalDays = StudentAttendance::whereMonth('date', $currentMonth)
            ->where('student_id', $studentId)->count();

        $presentDays = StudentAttendance::whereMonth('date', $currentMonth)
            ->where('student_id', $studentId)
            ->where('attend_status', 'Present')->count();

        $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) . '%' : '0%';

        $assign_subjects = AssignStudent::with('subject.school_subject')
            ->where('student_id', $studentId)
            ->first();

        $subjectCount = $assign_subjects ? $assign_subjects->subject->count() : 0;

        $recentMarks = StudentMarks::where('student_id', $studentId)
            ->latest('exam_type_id')
            ->first();

            $today = Carbon::now()->format('l');

        $data = AssignStudent::with([
            'timetable' => function ($query) use ($today) {
                $query->where('day', $today);
            },
            'timetable.subject'
        ])->where('student_id', $studentId)->first();

        $timetable = [];

        if ($data && $data->timetable) {
            foreach ($data->timetable as $entry) {
                $timetable[$entry->start_time] = $entry;
            }
        }
        return view('student.index', [
            'total_paid' => $totalPaid,
            'attendance_percentage' => $attendancePercentage,
            'recent_marks' => $recentMarks ? $recentMarks->marks : 'N/A',
            'subject'=> $recentMarks->school_subject->name,
            'subject_count' => $subjectCount,
            'timetable' => $timetable,
            'today' => $today
        ]);

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
