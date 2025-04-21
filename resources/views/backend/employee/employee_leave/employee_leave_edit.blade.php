@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">

            <div class="box">
            <div class="box-header with-border">
               <h4 class="box-title">Edit Employee Leave</h4>
            </div>
            
            <div class="box-body">
               <div class="row">
                  <div class="col">

                     <form method="post" action="{{ route('update.employee.leave', $editData->id) }}">
                        @csrf
                        <div class="row">
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                 <h5>Employee Name <span class="text-danger">*</span></h5>
                                 <div class="controls">
                                    <select name="employee_id" required="" class="form-control">
                                       <option value="" selected="" disabled="">Select Employee Name</option>
                                       @foreach($employees as $employee)
                                          <option value="{{ $employee->id }}" {{ ($editData->employee_id == $employee->id) ? 'selected' : '' }}>{{ $employee->lname }} {{ $employee->name }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group">
                                 <h5>Start Date <span class="text-danger">*</span></h5>
                                 <div class="controls">
                                    <input type="date" name="start_date" class="form-control" value="{{ $editData->start_date }}">
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group">
                                 <h5>Leave Purpose <span class="text-danger">*</span></h5>
                                 <div class="controls">
                                    <input type="text" name="reason" value="{{ $editData->reason }}" class="form-control">                 
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="form-group">
                                 <h5>End Date <span class="text-danger">*</span></h5>
                                 <div class="controls">
                                   <input type="date" name="end_date" class="form-control" value="{{ $editData->end_date }}">
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <div class="text-xs-right">
                           <input type="submit" class="btn btn-rounded btn-info mb-5" value="Update">
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