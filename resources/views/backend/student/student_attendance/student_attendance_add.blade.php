@extends('admin.admin_master')

@section('admin')
   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <form action="{{ route('student.attendance.getstudent') }}" method="get">
               <div class="row">
                  <div class="col-12">
                     <div class="box bb-3 border-warning">
                        <div class="box-header with-border">
                           <h3 class="box-title">Student Attenence</h3>
                        </div>
                        <div class="box-body">
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>year <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="year_id" class="form-control">
                                          <option value="" selected disabled>Select year</option>
                                          @foreach ($years as $year)
                                             <option value="{{ $year->id }}"  {{ @($year_id == $year->id) ? 'selected' : '' }}> {{ $year->name }}</option>                                    
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Class <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="class_id" class="form-control">
                                          <option value="" selected disabled>Select Class</option>
                                          @foreach ($classes as $class)
                                             <option value="{{ $class->id }}" {{ @($class_id == $class->id) ? 'selected':'' }}>{{ $class->name }}</option>                                    
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-2" style="padding-top: 25px;">
                                 <input type="submit" class="btn btn-rounded btn-dark mb-5" value="Search">
                              </div>

                           </div>

                        </div>
                     </div>
                  </div>
               </div>
            </form>

            @if(!empty($studentsData))
               <form action="{{ route('store.student.attendance') }}" method="POST">
                  @csrf
                  <!-- Hidden fields for common values -->
                  <input type="hidden" name="year_id" value="{{ $year_id }}">
                  <input type="hidden" name="class_id" value="{{ $class_id }}">

                  <div class="row">
                     <div class="col-12">
                        <div class="box bb-3 border-warning">
                           <div class="box-body">
                              <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <div class="controls">
                                          <input type="date" class="form-control" name="date" required>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <table id="example1" class="table">
                              <thead>
                                 <tr>
                                    <th>Rollno</th>
                                    <th>Name</th>
                                    <th>Last Name</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach ($studentsData as $student)
                                    <tr>
                                       <td>
                                          {{ $student['roll'] }}
                                          <input type="hidden" name="students[{{ $student['student_id'] }}][roll]" value="{{ $student['roll'] }}">
                                          <input type="hidden" name="students[{{ $student['student_id'] }}][student_id]" value="{{ $student['student_id'] }}">
                                       </td>
                                       <td>{{ $student['name'] }}</td>
                                       <td>{{ $student['lname'] }}</td>
                                       <td>
                                          <input type="radio" id="present_{{ $student['student_id'] }}" name="students[{{ $student['student_id'] }}][attend_status]" value="Present" checked required>
                                          <label for="present_{{ $student['student_id'] }}">Present</label>
                                          <input type="radio" id="absent_{{ $student['student_id'] }}" name="students[{{ $student['student_id'] }}][attend_status]" value="Absent">
                                          <label for="absent_{{ $student['student_id'] }}">Absent</label>
                                       </td>
                                    </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           <div class="col-md-2" style="padding-top: 25px;">
                              <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit Attendance">
                           </div>
                        </div>
                     </div>
                  </div>
               </form>

            @endif
         </section>
      </div>

   </div>
@endsection
