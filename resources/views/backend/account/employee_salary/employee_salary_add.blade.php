@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <div class="row">
               <div class="col-12">
                  <div class="box bb-3 border-warning">
                     <div class="box-header">
                        <h4 class="box-title">Add <strong>Employee Salary </strong></h4>
                     </div>
                 
                     <div class="box-body">
                        <form action="{{ route('account.salary.add') }}" method="get">
                           <div class="row">
                        
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <h5> Date <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-6" style="padding-top: 25px;">
                                 <input type="submit" class="btn btn-rounded btn-dark mb-5" value="search">
                              </div>
                           </div>
                        </form>
                   
                        @if(!empty($employees))
                           <form method="post" action="{{ route('account.salary.store') }}">
                              @csrf
                              <table class="table table-bordered">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>ID No</th>
                                       <th>Name</th>
                                       <th>Total working</th>
                                       <th>Absent</th>
                                       <th>Salary</th>
                                       <th>Total Salary</th>
                                       <th>Payment Date</th>
                                       <th>Status</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($employees as $key => $emp)
                                       <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>
                                             {{ $emp['id_no'] }}
                                             <input type="hidden" name="employee_id[]" value="{{ $emp['id'] }}">
                                          </td>
                                          <td>{{ $emp['name'] }}</td>
                                          <td>{{ $emp['totalwork'] }}</td>
                                          <td>{{ $emp['absent'] }}</td>
                                          <td>{{ number_format($emp['salary'], 2) }}</td>
                                          <td>
                                             <input type="number" name="totalsalary[{{ $emp['id'] }}]" value="{{ $emp['paid'] ? $emp['paid_amount'] : $emp['totalsalary'] }}" class="form-control">
                                          </td>
                                          <td>
                                             <input type="date" name="salary_date[{{ $emp['id'] }}]" value="{{ $emp['paid_date'] }}" class="form-control">
                                          </td>
                                          <td>
                                             @if ($emp['paid'])
                                                <span class="badge badge-success">Paid</span>
                                             @else
                                                <span class="badge badge-danger">Not Paid</span>
                                             @endif
                                          </td>
                                       </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                              <div>
                                 <input type="submit" class="btn btn-rounded btn-info mb-5" value="submit Salary">
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