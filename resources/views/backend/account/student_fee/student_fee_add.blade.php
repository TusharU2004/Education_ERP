@extends('admin.admin_master')
@section('admin')

    <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <div class="row">
               <div class="col-12">
                  <div class="box bb-3 border-warning">
                     <div class="box-header">
                        <h4 class="box-title">Add <strong>Student Fee </strong></h4>
                     </div>

                     <div class="box-body">

                        <form action="{{ route('student.fee.add') }}" method="get">
                        <div class="row">
                           <div class="col-md-3">
                              <div class="form-group">
                                 <h5>Year <span class="text-danger">*</span></h5>
                                 <div class="controls">
                                    <select name="year_id" required="" class="form-control">
                                       <option value="" selected="" disabled="">Select Year</option>
                                       @foreach($years as $year)
                                          <option value="{{ $year->id }}"{{ @($year->id == $year_id) ? 'selected' : '' }}>{{ $year->name }}</option>
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
                                          <option value="{{ $class->id }}" {{ @($class->id == $class_id) ? 'selected' : '' }}>{{ $class->name }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-3">
                              <div class="form-group">
                                 <h5>Fee Category <span class="text-danger">*</span></h5>
                                 <div class="controls">
                                    <select name="fee_category_id" id="fee_category_id" required="" class="form-control">
                                       <option value="" selected="" disabled="">Select Fee Category</option>
                                       @foreach($fee_categories as $fee)
                                          <option value="{{ $fee->id }}" {{ @($fee->id == $fee_category_id) ? 'selected' : '' }}>{{ $fee->name }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-3">
                              <div class="form-group">
                                 <h5> Date <span class="text-danger">*</span></h5>
                                 <div class="controls">
                                    <input type="month" name="date" value="{{ request('date') }}" class="form-control">
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-3">
                              <input type="submit" value="search" class="btn btn-rounded btn-dark mb-5">
                           </div>
                        </div>
                     </form>
                     
                     @if (!empty($students))
                     <div class="row">
                        <div class="col-md-12">
                           <form action="{{ route('account.fee.store') }}" method="post">
                              @csrf
                              <input type="hidden" name="year_id" value="{{ $year_id }}">
                              <input type="hidden" name="class_id" value="{{ $class_id }}">
                              <input type="hidden" name="fee_category_id" value="{{ $fee_category_id }}">
                              <div class="table-responsive">
                              <table class="table table-bordered">
                                 <thead>
                                    <tr>
                                          <th>ID No</th>
                                          <th>Student Name</th>
                                          <th>Original Fee</th>
                                          <th>Discount (%)</th>
                                          <th>Final Payable Fee</th>
                                          <th>Paid Amount</th>
                                          <th>Paid Date</th>
                                          <th>Description</th>
                                          <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                          <td>{{ $student['id_no'] }}
                                             <input type="hidden" name="id[]" value="{{ $student['id'] ?? '' }}">
                                          </td>
                                          <td >{{ $student['name'] }}</td>
                                          <td>{{ $student['original_fee'] }}</td>
                                          <td style="width: 20px;">{{ $student['discount'] }}%</td>
                                          <td>{{ $student['final_fee'] }}</td>
                                          <td>
                                             <input type="number" name="paid_amount[]" value="{{ $student['paid_amount'] ?? '' }}" class="form-control">
                                          </td>
                                          <td>
                                             @if($student['paid_date'])
                                                <input type="date" name="paid_date[]" value="{{ $student['paid_date'] }}" class="form-control">
                                             @else
                                                <input type="date" name="paid_date[]" class="form-control">
                                             @endif
                                          </td>
                                          <td>
                                            <input type="text" name="description[]" value="{{ $student['description'] ?? '' }}" class="form-control">
                                          </td>
                                          <td>
                                             @if ($student['paid_date'] == null)
                                                <span class="btn-sm btn-danger">Not Paid</span>
                                             @else
                                                <span class="btn btn-sm btn-success">Paid</span>
                                             @endif
                                          </td>
                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                              </div>
                              <div>
                                 <input type="submit" class="btn btn-rounded btn-info mb-5">
                              </div>
                           </form>
                        </div>
                     </div> 
                     @endif
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
@endsection