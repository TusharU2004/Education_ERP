@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <div class="row">
               <div class="col-12">
                  <div class="box bb-3 border-warning">
                     <div class="box-header">
                        <h4 class="box-title">Student <strong>Registration Fee</strong></h4>
                     </div>

                     <div class="box-body">
                     <form action="{{ route('registration.fee.view') }}" method="GET">
                        <div class="row">  
                           <div class="col-md-4">
                              <div class="form-group">
                                 <h5>Year <span class="text-danger">*</span></h5>
                                 <div class="controls">
                                    <select name="year_id" id="year_id" required="" class="form-control">
                                       <option value="" selected="" disabled="">Select Year</option>
                                       @foreach($years as $year)
                                          <option value="{{ $year->id }}" {{ @($year_id == $year->id) ? 'selected' : '' }}>{{ $year->name }}</option>
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
                                          <option value="{{ $class->id }}" {{ @($class_id == $class->id) ? 'selected' : ''}}>{{ $class->name }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-4" style="padding-top: 25px;">
                            <button type="submit">Search</button>
                              <input type="submit" value="search" class="btn btn-rounded btn-dark mb-5">
                           </div>
                        </div>
                        </form>
                        @if (!empty($allStudent))
                           <div class="table-responsive">
                              <table class="table table-bordered table-striped" id="example1" style="width: 100%">
                                 <thead>
                                    <th>SL</th>
                                    <th>ID No</th>
                                    <th>Student Name</th>
                                    <th>Roll No</th>
                                    <th>Reg Fee</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                 </thead>
                                 <tbody>
                                    @foreach ($allStudent as $student)
                                       <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $student->student->id_no }}</td>
                                          <td>{{ $student->student->lname }} {{ $student->student->name }} {{ $student->student->fname }}</td>
                                          <td>{{ $student->roll }}</td>
                                          <td>
                                            {{ $student->final_fee }}
                                          </td>
                                          <td>
                                             @if(isset($student->payment_date))
                                                {{ $student->payment_date }}
                                             @else
                                                <span class="btn-sm btn-danger">Not Paid</span>
                                             @endif
                                          </td>
                                          <td>
                                             @if(isset($student->payment_date))
                                                <a class="btn btn-sm btn-success" 
                                                   href="{{ route('student.registration.fee.payslip', ['class_id' => $student->class_id, 'student_id' => $student->student_id]) }}" 
                                                   target="_blank">
                                                   Receipt
                                                </a>
                                                <form action="{{ route('send.whatsapp') }}" method="post" style="display:inline-block;">
                                                   @csrf
                                                   <input type="hidden" name="student_id" value="{{ $student->student->id }}">
                                                   <input type="hidden" name="message" value="Dear {{ $student->student->name }} {{ $student->student->lname }}, your Registration fee of ₹{{ $student->registration_fee }} has been processed. Payment Date: {{ \Carbon\Carbon::parse($student->payment_date)->format('d M Y') }}. Thank you!">
                                                   <input type="submit" value="Send WhatsApp" style="background-color:#00BC8B;color:#fff; padding: 5px 8px;font-size: 9px; border-radius: 4px;">
                                                </form>
                                             @else
                                                <a class="btn btn-sm btn-primary" href="{{ route('student.fee.add')}}">
                                                   Pay Now
                                                </a>
                                                <form action="{{ route('send.whatsapp') }}" method="post" style="display:inline-block;">
                                                   @csrf
                                                   <input type="hidden" name="student_id" value="{{ $student->student_id }}">
                                                   <input type="hidden" name="message" value="Dear {{ $student->student->name }} {{ $student->student->lname }}, Your Registration fee of ₹{{ $student->final_fee }} has been pending. Please pay at the earliest.">
                                                   <input type="submit" value="send Remainder" style="background-color:rgb(234, 145, 22);color: #fff; padding: 5px 8px; font-size: 9px; border-radius: 4px;">
                                                </form>
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
               </div>
            </div>
         </section>
      </div>
   </div>

@endsection