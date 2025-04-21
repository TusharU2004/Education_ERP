@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <div class="row">
               <div class="col-12">
                  <div class="box">
                     <div class="box-header with-border">
                        <h3 class="box-title">Employee Salary List</h3>
                     </div>
                     
                     <div class="box-body">
                        <div class="table-responsive">
                           <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                 <tr>
                                    <th width="5%">SL</th>
                                    <th>Name</th>
                                    <th>ID NO</th>
                                    <th>Mobile</th>
                                    <th>Gender</th>
                                    <th>Join Date</th>
                                    <th>Salary</th>
                                    <th width="20%">Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($allData as $emp_salary)
                                    <tr>
                                       <td>{{ $loop->iteration }}</td>
                                       <td> {{ $emp_salary->name }}</td>
                                       <td> {{ $emp_salary->id_no }}</td>
                                       <td> {{ $emp_salary->mobile }}</td>
                                       <td> {{ $emp_salary->gender }}</td>
                                       <td> {{ date('d-m-Y', strtotime($emp_salary->join_date))  }}</td>
                                       <td> {{ $emp_salary->salary }}</td>
                                       <td>
                                          <a title="Increment" href="{{ route('employee.salary.increment', $emp_salary->id) }}"class="btn btn-info">
                                             <i class="fa fa-plus-circle"></i>
                                          </a>
                                          <a title="Details" href="{{ route('employee.salary.details', $emp_salary->id) }}" class="btn btn-primary">
                                             <i class="fa fa-eye"></i>
                                          </a>
                                       </td>
                                    </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>

      </div>
   </div>

@endsection