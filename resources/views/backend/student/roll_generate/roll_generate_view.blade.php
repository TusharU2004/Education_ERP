@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <div class="row">
               <div class="col-12">
                  <div class="box bb-3 border-warning">
                     <div class="box-header">
                        <h4 class="box-title">Student <strong>Roll Generator</strong></h4>
                     </div>

                     <div class="box-body">

                        <form method="get" action="{{ route('roll.generate.view') }}">
                           
                           <div class="row">

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Year <span class="text-danger">*</span></h5>
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
                                 <input type="submit" class="btn btn-rounded btn-dark mb-5" value="Search">
                              </div>
                           </div>   
                        </form>
                        
                        @if (!empty($allData))
            
                        <form method="post" action="{{ route('roll.generate.store') }}">
                           @csrf
                           <input type="hidden" name="year_id" value="{{ $year_id }}">
                           <input type="hidden" name="class_id" value="{{ $class_id }}">
                           <div class="table-responsive">
                              <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                              <thead>
                              <tr>
                                 <th>SL</th>
                                 <th>ID No</th>
                                 <th>Student Name </th>
                                 <th>Last Name </th>
                                 <th>Gender</th>
                                 <th>Roll</th>
                              </tr>
                              </thead>
                              <tbody id="roll-generate-tr">
                                 @foreach ($allData as $student)
                                 <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student['student']['id_no'] }}<input type="hidden" name="student_id[]" value="{{ $student['student_id'] }}"></td>
                                    <td>{{ $student['student']['name'] }}</td>
                                    <td>{{ $student['student']['lname'] }}</td>
                                    <td>{{ $student['student']['gender'] }}</td>
                                    <td><input type="text" class="form-control form-control-sm" name="roll[]" value="{{ $student['roll'] }}"></td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           </div>

                           <div class="col-md-4" style="padding-top: 25px;">
                              <input type="submit" class="btn btn-info" value="Roll Generator">
                           </div>
                        </form>
                        @endif
                     </div>
                     
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>

@endsection