@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <div class="box bb-3 border-warning">
               <div class="box-header">
                  <h4 class="box-title">Manage <strong>Student ID Card</strong></h4>
               </div>

               <div class="box-body">
                  <form method="GET" action="{{ route('student.idcard.view') }}">
                     <div class="row">
                        
                        <div class="col-md-4">
                           <div class="form-group">
                              <h5>Year <span class="text-danger"> *</span></h5>
                              <div class="controls">
                                 <select name="year_id" id="year_id" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select Year</option>
                                    @foreach($years as $year)
                                       <option value="{{ $year->id }}" {{ @($year_id == $year->id) ? 'selected':'' }}>{{ $year->name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-4">
                           <div class="form-group">
                              <h5>Class <span class="text-danger">*</span></h5>
                              <div class="controls">
                                 <select name="class_id" id="class_id" required="" class="form-control">
                                    <option value="" selected="" disabled="">Select Class</option>
                                    @foreach($classes as $class)
                                       <option value="{{ $class->id }}" {{ @($class_id == $class->id) ? 'selected':'' }}>{{ $class->name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-4" style="padding-top: 25px;">
                           <input type="submit" class="btn btn-rounded btn-dark" value="Search">
                        </div>
                     
                     </div>
                  </form>
                  @if (!empty($allStudent))
                  <div class="table-responsive">
                     <table id="example1" class="table table-striped">
                     <thead>
                        <th>SL</th>
                        <th>ID</th>
                        <th>Roll No</th>
                        <th>Student Name</th>
                        <th>action</th>
                     </thead>
                     <tbody>
                        @foreach ($allStudent as $student)
                           <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $student->student->id_no }}</td>
                              <td>{{ $student->roll }}</td>
                              <td>{{ $student->student->lname }} {{ $student->student->name }} {{ $student->student->fname }}</td>
                              <td>
                                 <a class="btn btn-sm btn-primary" target="_blank" href="{{ route('student.idcard.get',['id_no'=>$student->student->id_no,'id'=>$student->student->id]) }}">View ID</a>
                              </td>
                           </tr>                     
                        @endforeach
                     </tbody>
                     </table>
                  </div>
                  @endif
               </div>
            </div>
         </section>
      </div>
   </div>

@endsection