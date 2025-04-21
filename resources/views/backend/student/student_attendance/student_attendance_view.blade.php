@extends('admin.admin_master')
@section('admin')
    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="box bb-3 border-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Student Attendance Date: {{ date('d-m-Y') }}</h3>
                                <a href="{{ route('student.attendance.add') }}" style="float: right;"
                                    class="btn btn-rounded btn-success mb-5">
                                    Add Student Attendance
                                </a>
                            </div>
                            <br>
                            @if (!empty($classReport))
                                <table class="table" id="example1">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Class Name</th>
                                            <th>Total Student</th>
                                            <th>Total Present</th>
                                            <th>Total Absent</th>
                                            <th>Attendance Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classReport as $class)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $class['class_name'] }}</td>
                                                <td>{{ $class['total_students'] }}</td>
                                                <td>{{ $class['present_students'] }}</td>
                                                <td>{{ $class['absent_students'] }}</td>
                                                <td>
                                                    @if ($class['attendance_status'] == "Pending")
                                                        <span class="text-danger">Pending</span>
                                                    @else
                                                        <span class="text-success">Completed</span>
                                                        @if ($class['attendance_status'] == "Completed")
                                                            <form action="{{ route('send.daily.attendance.whatsapp') }}" method="POST"
                                                                style="margin-top:20px;">
                                                                @csrf
                                                                <input type="hidden" name="class_id" value="{{ $class['class_id'] }}">
                                                                <input type="hidden" name="attendance_date" value="{{ date('Y-m-d') }}">
                                                                <input type="submit" value="Send on WhatsApp"
                                                                    style="background-color:#00BC8B;color:#fff; padding: 5px 8px;font-size: 9px; border-radius: 4px;">
                                                            </form>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection