@extends('student.student_master')
@section('student')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <h2>Student Result</h2>

               <form action="{{ route('student.exam.result') }}" method="get">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group">
                           <h5>Select Exam Type<span class="text-danger">*</span></h5>
                           <select name="exam" class="form-control">
                              <option value="" selected="" disabled="">Select Exam</option>
                              @foreach ($exams as $exam)
                                 <option value="{{ $exam->id }}" {{ @($exam_id == $exam->id) ? 'selected' : '' }}>{{ $exam->name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>

                     <div class="col-md-6" style="padding-top: 25px;">
                        <input type="submit" class="btn btn-rounded btn-info mb-5" value="Search">
                     </div>
                  </div>
               </form>


               @if(isset($students) && count($students) > 0)
                  <div class="row">
                     <div class="col-md-12">
                        <h4>Total Marks: <strong>{{ $totalObtainedMarks }} / {{ $totalFullMarks }}</strong></h4>
                        <h4>Percentage: <strong>{{ $percentage }}%</strong></h4>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-12">
                        <div class="table-responsive">
                           <table class="table">
                              <thead>
                                 <th>SL</th>
                                 <th>Subject Code</th>
                                 <th>Subject Name</th>
                                 <th>Total Marks</th>
                                 <th>Obtained Marks</th>
                                 <th>Status</th>
                              </thead>
                              <tbody>
                                 @foreach ($students as $key => $student)
                                 <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $student->assign_subject->id }}</td>
                                    <td>{{ $student->school_subject->name }}</td>
                                    <td>{{ $student->assign_subject->full_mark }}</td>
                                    <td>{{ $student->marks }}</td>
                                    <td>
                                       @if($student->marks >= $student->assign_subject->pass_mark)
                                          <span class="text-success">Pass</span>
                                       @else
                                          <span class="text-danger">Fail</span>
                                       @endif
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               @endif
         </section>
      </div>
   </div>

@endsection