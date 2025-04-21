<?php

namespace App\Http\Controllers\backend\student;

use App\Http\Controllers\Controller;
use App\Models\StudentClass;
use App\Models\TimeTable;
use Illuminate\Http\Request;

class StudentTimeTableController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Time Table')->only('TimeTableView');
        $this->middleware('permission:Add Time Table')->only('TimeTableAdd');
        $this->middleware('permission:Edit Time Table')->only('TimeTableEdit');
        $this->middleware('permission:Delete Time Table')->only('TimeTableDelete');
    }
    public function TimeTableView(Request $request)
    {
        $classes = StudentClass::all();

        $class_id = $request->input('class_id');
        $timetable = collect();

        if ($class_id) {
            $timetable = Timetable::where('class_id', $class_id)
                ->orderBy('day')
                ->orderBy('start_time')
                ->get()
                ->groupBy('day');

        }

        return view('backend.student.timetable.timetable_view', compact('timetable', 'classes', 'class_id'));
    }


    public function TimeTableAdd()
    {
        $classes = StudentClass::all();
        $timetables = TimeTable::all();
        return view('backend.student.timetable.timetable_add', compact('classes', 'timetables'));
    }


    public function TimeTableStore(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ], [
            'class_id.required' => 'Please Select Class Name',
            'subject_id.required' => 'Please Select Subject '
        ]);

        $data = new TimeTable();

        $data->class_id = $request->class_id;
        $data->subject_id = $request->subject_id;
        $data->day = $request->day;
        $data->start_time = $request->start_time;
        $data->end_time = $request->end_time;

        if ($data->save()) {
            $notification = array(
                'message' => 'Time Table Added Successfully',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Error to add time table',
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);
    }

    public function TimeTableEdit($id)
    {
        $editData = TimeTable::find($id);
        $classes = StudentClass::all();
        return view('backend.student.timetable.timetable_edit', compact('editData', 'classes'));

    }

    public function TimeTableUpdate(Request $request, $id)
    {

        $data = TimeTable::find($id);
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $data->class_id = $request->class_id;
        $data->subject_id = $request->subject_id;
        $data->day = $request->day;
        $data->start_time = $request->start_time;
        $data->end_time = $request->end_time;

        if ($data->save()) {
            $notification = array(
                'message' => 'Class time table updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('student.timetable.add')->with($notification);
        } else {
            $notification = array(
                'message' => 'Error to update Class Time table',
                'alert-type' => 'error'
            );
            return redirect()->route('student.timetable.add')->with($notification);
        }

    }

    public function TimeTableDelete($id)
    {
        if (TimeTable::find($id)->delete()) {
            $notification = array(
                'message' => 'Class time table Deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Error in delete Class time table',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

    }
}