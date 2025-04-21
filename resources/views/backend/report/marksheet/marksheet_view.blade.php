@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <div class="box bb-3 border-warning">
               <div class="box-header">
                  <h4 class="box-title">Manage <strong>MarkSheet Generate</strong></h4>
               </div>

               <div class="box-body">

                  <form method="GET" action="{{ route('marksheet.generate.view') }}">
                     
                     <div class="row">
                        
                        <div class="col-md-3">
                           <div class="form-group">
                              <h5>Year <span class="text-danger">*</span></h5>
                              <div class="controls">
                                 <select name="year_id" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select Year</option>
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
                                 <select name="class_id" id="class_id" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select Class</option>
                                       @foreach($classes as $class)
                                          <option value="{{ $class->id }}" {{ @($class_id == $class->id ) ? 'selected' : '' }}>{{ $class->name }}</option>
                                       @endforeach
                                 </select>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                              <h5>Exam Type <span class="text-danger">*</span></h5>
                              <div class="controls">
                                 <select name="exam_type_id" id="exam_type_id" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select Class</option>
                                       @foreach($exam_type as $exam)
                                          <option value="{{ $exam->id }}" {{ @($exam_type_id == $exam->id ) ? 'selected' : '' }}>{{ $exam->name }}</option>
                                       @endforeach
                                 </select>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-3" style="margin-top:25px;">
                           <input type="submit" class="btn btn-rounded btn-dark" value="Search">
                        </div>
                        @if (!empty($allStudent))
                           <div class="table-responsive">
                              <table id="example1" class="table table-striped">
                                 <thead>
                                    <th>SL</th>
                                    <th>ID</th>
                                    <th>Roll No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                 </thead>
                                 <tbody>
                                    @foreach ($allStudent as $student)
                                       <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $student->roll }}</td>
                                          <td>{{ $student->student->id_no }}</td>
                                          <td>{{ $student->student->lname }} {{ $student->student->name }} {{ $student->student->fname }}</td>
                                          <td>
                                             <a target="_blank" class="btn btn-sm btn-primary" href="{{ route('report.marksheet.get',[
                                                'id_no'=>$student->student->id_no,
                                                'year_id'=>$year_id,
                                                'class_id'=>$class_id,
                                                'exam_type_id'=>$exam_type_id
                                                ])}}">View MarkSheet</a>
                                          </td>
                                       </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        @endif
                     </div>
                  </form>
               </div>
            </div>
         </section>
      </div>
   </div>

@endsection