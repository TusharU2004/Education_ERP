@extends('admin.admin_master')
@section('admin')
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">

            <div class="box">
               <div class="box-header with-border">
                  <h4 class="box-title">Employee Leave</h4>
               </div>
               
               <div class="box-body">
                  <div class="row">
                     <div class="col">

                        <form method="post" action="{{ route('store.employee.leave') }}">
                           @csrf
                           <div class="row">

                              <div class="col-md-6">
                                 <div class="form-group">
                                    <h5>Employee Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="employee_id" class="form-control">
                                          <option value="" selected="" disabled="">Select Employee Name</option>
                                          @foreach($employees as $employee)
                                             <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                          @endforeach
                                       </select>
                                       @error('employee_id')<span class="text-danger">{{ $message }}</span>
                                       @enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="form-group">
                                    <h5>Start Date <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="date" name="start_date" class="form-control">
                                       @error('start_date')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="form-group">
                                    <h5>Leave Purpose <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="reason" class="form-control">
                                       @error('reason')<span class="text-danger">{{ $message }}</span>
                                       @enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="form-group">
                                    <h5>End Date <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="date" name="end_date" class="form-control">
                                       @error('end_date')<span class="text-danger">{{ $message }}</span>
                                       @enderror
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="text-xs-right">
                              <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>

@endsection