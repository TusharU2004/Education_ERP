@extends('student.student_master')
@section('student')

<div class="content-wrapper">
   <div class="container-full">
      <section class="content">
         <h2>Student Class Time Table</h2>
         
         <div class="row">
            <div class="col-12">
               <div>
                  <table class="table table-bordered text-center">
                     <thead>
                        <tr>
                           <th>Time Slot</th>
                           <th>Monday</th>
                           <th>Tuesday</th>
                           <th>Wednesday</th>
                           <th>Thursday</th>
                           <th>Friday</th>
                           <th>Saturday</th>
                           <th>Sunday</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php
                           $start_time = \Carbon\Carbon::createFromTime(8, 0, 0);
                           $lecture_duration = 45;
                           $break_duration = 15;
                        @endphp

                        @for ($i = 1; $i <= 6; $i++)
                           @php
                              $end_time = (clone $start_time)->addMinutes($lecture_duration);
                              $time_slot = $start_time->format('H:i:s');
                              $display_time_slot = $start_time->format('h:i A') . ' - ' . $end_time->format('h:i A');
                           @endphp

                           <tr>
                              <td>{{ $display_time_slot }}</td>
                              @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                 <td>
                                    @if (isset($timetable[$day][$time_slot]))
                                       {{ $timetable[$day][$time_slot]->subject->name ?? 'N/A' }}<br>
                                       Teacher: {{ $timetable[$day][$time_slot]->teacher->name ?? 'N/A' }}
                                    @else
                                       ---
                                    @endif
                                 </td>
                              @endforeach
                           </tr>

                           @php
                              $start_time = (clone $end_time);
                           @endphp

                           @if ($i == 3)
                              <tr>
                                 <td colspan="8" class="bg-warning text-bold">Break (15 Min)</td>
                              </tr>
                              @php
                                 $start_time->addMinutes($break_duration);
                              @endphp
                           @endif
                        @endfor
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </section>
   </div>
</div>

@endsection
