@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">

            <div class="box bb-3 border-warning">
               <div class="box-header">
                  <h4 class="box-title">Employee <strong>Monthly Salary</strong></h4>
               </div>

               <div class="box-body">

                  <form action="{{ route('employee.monthly.salary') }}">
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <h5>Select Salary Month & year<span class="text-danger">*</span></h5>
                              <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                           </div>
                        </div>
                        
                        <div class="col-md-6" style="padding-top: 25px;">
                           <input type="submit" class="btn btn-rounded btn-dark mb-5">
                        </div>
                     </div>
                  </form>

                  @if (!empty($EmployeeData))
                     <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                           <thead>
                              <tr>
                                 <th>SL</th>
                                 <th>ID</th>
                                 <th>Name</th>
                                 <th>Salary</th>
                                 <th>Total Working Days</th>
                                 <th>Present Days</th>
                                 <th>This month Salary</th>
                                 <th>Payment Date</th>
                                 <th>Status</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($EmployeeData as $employee)
                                 <tr>
                                    <input type="hidden" name="month" value="{{ $employee['salary_month'] }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $employee['id_no'] }}</td>
                                    <td>{{ $employee['name'] }}</td>
                                    <td>{{ $employee['salary'] }}</td>
                                    <td>{{ $employee['total_working_days'] }}</td>
                                    <td>{{ $employee['present_days'] }}</td>
                                    <td>
                                       @if (!empty($employee['paid_amount']))
                                          {{ $employee['paid_amount'] }}
                                       @else
                                          {{ $employee['total_salary'] }}
                                       @endif
                                    </td>
                                    <td>
                                       @if ($employee['paid'])
                                          <span class="badge badge-info">{{ $employee['paid_date'] }}</span>
                                       @else
                                          <span class="badge badge-danger">NOT PAID</span>
                                       @endif
                                    </td>
                                    <td>
                                       @if ($employee['paid'])
                                          <a class="btn btn-sm btn-primary" title="PaySlip" target="_blank"
                                          href="{{ route('employee.monthly.salary.payslip', ['employee_id' => $employee['id'],'month' => $employee['salary_month']])}}">
                                          Print Receipt
                                          </a>
                                       @else
                                          <span class="badge badge-danger">Not Paid</span>
                                       @endif
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