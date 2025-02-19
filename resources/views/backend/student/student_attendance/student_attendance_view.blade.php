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
                     class="btn btn-rounded btn-success mb-5">Add Student Attendance</a>
                 </div>
                 <br>
                 <table class="table" id="example1">
                   <thead>
                     <th>Sl</th>
                     <th>Class Name</th>
                     <th>Total Student</th>
                     <th>Total Present</th>
                     <th>Total Absent</th>
                     <th>Attendace Status</th>
                   </thead>
                   <tbody>
                     @foreach ($classReport as $class)
                   <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>{{ $class['class_name'] }}</td>
                     <td>{{ $class['total_students'] }}</td>
                     <td>{{ $class['present_students'] }}</td>
                     <td>{{ $class['absent_students'] }}</td>
                     <td>@if ($class['attendance_status'] == "Pending")
                     <span class="text-danger">pending</>
                  @else
                  <span class="text-success">Completed</span>
               @endif
                     </td>
                   </tr>
                @endforeach
                   </tbody>
                 </table>
               </div>

            </div>
          </div>


        </section>
      </div>
   </div>
@endsection