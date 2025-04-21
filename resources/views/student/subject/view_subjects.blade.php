@extends('student.student_master')
@section('student')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">
            <h2>Student Assign Suject List</h2>
            <div class="row">
               <div class="col-12">
                  <div>
                     <table class="table">
                        <thead>
                           <th>SL</th>
                           <th>Subject Code</th>
                           <th>Subject Name</th>
                           <th>Assignment</th>
                        </thead>
                        <tbody>
                           @foreach ($assign_subject as $subject)
                              <tr>
                                 <td>{{ $loop->iteration }}</td>
                                 <td>{{ $subject->id }}</td>
                                 <td>{{ $subject['school_subject']['name'] }}</td>
                                 <td>Not Assign</td>
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