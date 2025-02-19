@extends('admin.admin_master')
@section('admin')

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   <div class="content-wrapper">
      <div class="container-full">
         <section class="content">
            <div class="row">
               <div class="col-12">
                  <div class="box bb-3 border-warning">
                     <div class="box-header">
                        <h4 class="box-title">Student <strong>Marks Entry</strong></h4>
                     </div>
                     <div class="box-body">
                        <form method="get" action="{{ route('marks.entry.get') }}">
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Year <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="year_id" required class="form-control">
                                          <option value="" selected disabled>Select Year</option>
                                          @foreach($years as $year)
                                             <option value="{{ $year->id }}" {{ @($year_id == $year->id) ? 'selected' : '' }}>{{ $year->name }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Class <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="class_id" id="class_id" required class="form-control">
                                          <option value="" selected disabled>Select Class</option>
                                          @foreach($classes as $class)
                                             <option value="{{ $class->id }}" {{ @($class_id == $class->id) ? 'selected' : '' }}>{{ $class->name }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Exam Type <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="exam_type_id" id="exam_type_id" required class="form-control">
                                          <option value="" selected disabled>Select Exam Type</option>
                                          @foreach($exam_types as $exam)
                                             <option value="{{ $exam->id }}" {{ @($exam_type_id == $exam->id) ? 'selected' : '' }}>{{ $exam->name }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Subject <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="assign_subject_id" id="subject_id" required class="form-control">
                                          <option value="" selected disabled>Select Subject</option>
                                          @if(isset($subjects))
                                             @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}" {{ @($assign_subject_id == $subject->id) ? 'selected' : '' }}>{{ $subject->name }}</option>
                                             @endforeach
                                          @endif
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <input type="submit" value="Search" class="btn btn-rounded btn-dark mb-5">
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            @if (!empty($students))
               <form action="{{ route('marks.entry.store') }}" method="post">
                  @csrf
                  <input type="hidden" name="year_id" value="{{ $year_id }}">
                  <input type="hidden" name="class_id" value="{{ $class_id }}">
                  <input type="hidden" name="exam_type_id" value="{{ $exam_type_id }}">
                  <input type="hidden" name="assign_subject_id" value="{{ $assign_subject_id }}">
                  
                  <div class="box bb-3 border-warning">
                     <div class="box-body">
                        <div class="table-responsive">
                           <table class="table" id="example1">
                              <thead>
                                 <th width="15%">Roll Number</th>
                                 <th>Unique ID</th>
                                 <th>Student Name</th>
                                 <th>Last Name</th>
                                 <th width="20%">Obtain Marks</th>
                              </thead>
                              <tbody>
                                 @foreach ($students as $key => $student)
                                    <tr>
                                       <td>
                                          {{ $student->roll }}
                                          <input type="hidden" name="student_id[]" value="{{ $student->student_id }}">
                                       </td>
                                       <td>
                                          {{ $student->student->id_no }}
                                          <input type="hidden" name="id_no[]" value="{{ $student->student->id_no }}">
                                       </td>
                                       <td>{{ $student->student->name }}</td>
                                       <td>{{ $student->student->lname }}</td>
                                       <td>
                                          @php
                                             $existing_mark = $studentMarks[$student->student_id]->marks ?? '';
                                          @endphp
                                          <input type="text" class="form-control form-control-sm" name="marks[]" value="{{ $existing_mark }}">
                                       </td>
                                    </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                        <input type="submit" class="btn btn-primary">
                     </div>
                  </div>
               </form>
            @endif
         </section>
      </div>
   </div>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
      $(document).ready(function() {
         $('#class_id').change(function() {
            var class_id = $(this).val();
            if (class_id) {
               $.ajax({
                  url: "{{ route('marks.getsubject') }}",
                  type: "GET",
                  data: { class_id: class_id },
                  success: function(data) {
                     $('#subject_id').empty();
                     $('#subject_id').append('<option value="" selected disabled>Select Subject</option>');
                     $.each(data, function(key, subject) {
                        $('#subject_id').append('<option value="' + subject.id + '"' + 
                           (subject.id == "{{ $assign_subject_id ?? '' }}" ? 'selected' : '') + '>' + subject.name + '</option>');
                     });
                  }
               });
            }
         });
      });
   </script>
@endsection
