@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">
         <section class="content">
            <div class="row">
               <div class="col-12">
                  <div class="box bb-3 border-warning">
                     <div class="box-header">
                     <h4 class="box-title">Student <strong>Marks View</strong></h4>
                     </div>
                     
                     <div class="box-body">
                        <form method="GET" action="{{ route('marks.entry.view') }}">
                           <div class="row">

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Year <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="year_id" required class="form-control">
                                          <option value="" selected disabled>Select Year</option>
                                          @foreach($years as $year)
                                             <option value="{{ $year->id }}" {{ @($year_id == $year->id) ? 'selected' : '' }}>
                                                {{ $year->name }}
                                             </option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Class <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="class_id" required class="form-control">
                                          <option value="" selected disabled>Select Class</option>
                                          @foreach($classes as $class)
                                             <option value="{{ $class->id }}" {{ @($class_id == $class->id) ? 'selected' : '' }}>
                                                {{ $class->name }}
                                             </option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Exam Type <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="exam_type_id" required class="form-control">
                                          <option value="" selected disabled>Select Exam Type</option>
                                          @foreach($exam_types as $exam)
                                             <option value="{{ $exam->id }}" {{ @($exam_type_id == $exam->id) ? 'selected' : '' }}>
                                                {{ $exam->name }}
                                             </option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                              <input type="submit" value="Search" class="btn btn-rounded btn-dark mb-5"
                                 style="margin-top:22px;">
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>

               @if(!empty($students))
                  <div class="col-12">
                     <div class="box bb-3 border-warning">
                        <div class="box-header">
                           <h4 class="box-title">Student <strong>Marks List</strong></h4>
                        </div>
                        
                        <div class="box-body">
                           <div class="table-responsive">
                              <table id="example1" class="table table-bordered">
                                 <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Subjects & Marks</th>
                                    <th>Total Marks</th>
                                    <th>Percentage</th>
                                    <th>Rank</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($students as $student)
                                       <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $student['id_no'] }}</td>
                                          <td>{{ $student['student_name'] }}</td>
                                          <td>
                                             @foreach ($student['marks'] as $mark)
                                                <strong>{{ $mark->school_subject->name }}:</strong> {{ $mark->marks }} <br>
                                             @endforeach
                                          </td>
                                          <td>{{ $student['total_marks'] }}</td>
                                          <td>{{ number_format($student['percentage'], 2) }}%</td>
                                          <td>{{ $student['rank'] }}</td>
                                       </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               @endif
            </div>
         </section>
      </div>
   </div>

@endsection