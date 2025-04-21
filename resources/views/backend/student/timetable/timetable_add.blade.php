@extends('admin.admin_master')

@section('admin')
   <div class="content-wrapper">
      <div class="container-full">
        <section class="content">
          <div class="box bb-3 border-warning">
            <div class="box-header">
               <h4 class="box-title">Add Class Timetable</h4>
            </div>

            <div class="box-body">
               
               <form action="{{ route('student.timetable.store') }}" method="post">
                  @csrf
                  <div class="row">

                     <div class="col-md-3">
                        <div class="form-group">
                           <h5>Class <span class="text-danger">*</span></h5>
                           <div class="controls">
                              <select name="class_id" id="class_id" class="form-control">
                                 <option value="" selected disabled>Select Class</option>
                                 @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                 @endforeach
                              </select>
                              @error('class_id')<span class="text-danger">{{ $message }}</span>@enderror
                           </div>
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="form-group">
                           <h5>Subject <span class="text-danger">*</span></h5>
                           <div class="controls">
                              <select name="subject_id" id="subject_id" class="form-control">
                                 <option value="" selected disabled>Select Subject</option>
                              </select>
                              @error('subject_id')<span class="text-danger">{{ $message }}</span>@enderror
                           </div>
                        </div>
                     </div>

                     <div class="col-md-2">
                        <div class="form-group">
                           <h5>Day <span class="text-danger">*</span></h5>
                           <div class="controls">
                              <select name="day" class="form-control">
                                 <option value="" selected disabled>Select Day</option>
                                 <option value="Monday">Monday</option>
                                 <option value="Tuesday">Tuesday</option>
                                 <option value="Wednesday">Wednesday</option>
                                 <option value="Thursday">Thursday</option>
                                 <option value="Friday">Friday</option>
                                 <option value="Saturday">Saturday</option>
                                 <option value="Sunday">Sunday</option>
                              </select>
                              @error('day')<span class="text-danger">{{ $message }}</span>@enderror
                           </div>
                        </div>
                     </div>

                     <div class="col-md-2">
                        <div class="form-group">
                           <h5>Start Time <span class="text-danger">*</span></h5>
                           <input type="time" name="start_time" class="form-control" >
                           @error('start_time')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                     </div>

                     <div class="col-md-2">
                        <div class="form-group">
                           <h5>End Time <span class="text-danger">*</span></h5>
                           <input type="time" name="end_time" class="form-control">
                           @error('end_time')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                     </div>
                     
                     
                  </div>
                  <div class="d-flex justify-content-center mt-3">
                        <input type="submit" class="btn btn-info" value="Save Timetable">
                     </div>
               </form>
               </div>
               </div>
               <div class="box bb-3 border-warning">

               <div class="box-body">
               <table class="table" id="example1">
                  <thead>
                     <th>Sl</th>
                     <th>Class</th>
                     <th>Subject</th>
                     <th>Day</th>
                     <th>Start_time</th>
                     <th>end_time</th>

                     <th>Action</th>
                  </thead>
                  <tbody>
                     @foreach ($timetables as $timetable)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $timetable->class->name }}</td>
                        <td>{{ $timetable->subject->name }}</td>
                        <td>{{ $timetable->day }}</td>
                        <td>{{ $timetable->start_time }}</td>
                        <td>{{ $timetable->end_time }}</td>
                        <td>
                           @can('Edit Time Table')
                              <a href="{{ route('student.timetable.edit',$timetable->id) }}" class="btn btn-info">Edit</a>
                           @endcan

                           @can('Delete Time Table')
                              <a href="{{ route('student.timetable.delete',$timetable->id) }}" id="delete" class="btn btn-danger">Delete</a>
                           @endcan
                        </td>
                     </tr>
                     @endforeach

                  </tbody>
               </table>
            </div>
         </div>
        </section>
      </div>
   </div>

   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
      $(document).ready(function () {
        $('#class_id').change(function () {
          var class_id = $(this).val();
          if (class_id) {
            $.ajax({
               url: "{{ route('marks.getsubject') }}",
               type: "GET",
               data: { class_id: class_id },
               success: function (data) {
                 $('#subject_id').empty();
                 $('#subject_id').append('<option value="" selected disabled>Select Subject</option>');
                 $.each(data, function (key, subject) {
                   $('#subject_id').append('<option value="' + subject.subject_id + '"' +
                     (subject.id == "{{ $assign_subject_id ?? '' }}" ? 'selected' : '') + '>' + subject.school_subject.name + '</option>');
                 });
               }
            });
          }
        });
      });
   </script>
   
@endsection
