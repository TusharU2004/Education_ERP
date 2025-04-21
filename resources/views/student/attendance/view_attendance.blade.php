@extends('student.student_master')
@section('student')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <h2>Student Attendance</h2>
            <h4>Total Attendance :- 
               @if ($percentage>=75)
                  <span class="text-success">{{ $percentage }}%</span>
               @else
                  <span class="text-danger">{{ $percentage }}%</span>
               @endif
            </h4>
            <div class="row">
               <div class="col-12">
                  <div>
                     <table class="table" id="example1">
                        <thead>
                           <th>SL</th>
                           <th>Date</th>
                           <th>Attendance Status</th>
                        </thead>
                        <tbody>
                           @foreach ($attendance as $att)
                              <tr>
                                 <td>{{ $loop->iteration }}</td>
                                 <td>{{ $att->date }}</td>
                                 <td>
                                    @if ($att->attend_status == 'Absent')
                                    <span class="text-danger">{{ $att->attend_status }}</span>
                                    @else
                                    <span class="text-success">{{ $att->attend_status }}</span>
                                    @endif
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>


@endsection