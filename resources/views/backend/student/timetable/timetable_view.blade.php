@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">
         <section class="content">
            <div class="box bb-3 border-warning">
               <div class="box-header with-border">
                  <h3 class="box-title">Class Timetable </h3>
                  @can('Add Time Table')
                     <a href="{{ route('student.timetable.add') }}" style="float: right;" class="btn btn-rounded btn-success mb-5">Add/edit Class Time Table</a>
                  @endcan
               </div>
               
               <div class="box-body">
                  <form method="GET" action="{{ route('student.timetable.view') }}">
                     <div class="row">
                        <div class="col-md-4">
                           <h4>Select Class:</h4>
                           <select name="class_id" id="class_id" class="form-control">
                              <option value="">Select Class</option>
                              @foreach($classes as $class)
                                 <option value="{{ $class->id }}" {{ $class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                  </form>

                  <br>

                  @if ($class_id)
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
                                 $time_slot = $start_time->format('h:i A') . ' - ' . $end_time->format('h:i A');
                              @endphp

                              <tr>
                                 <td>{{ $time_slot }}</td>
                                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                 <td>
                                    @if (isset($timetable[$day]))
                                    
                                       @php
                                          $lecture = $timetable[$day]->where('start_time', $start_time->format('H:i:s'))->first();
                                       @endphp
                                       
                                       @if ($lecture)
                                          {{ $lecture->subject->name ?? 'N/A' }}<br>
                                          Teacher: {{ $lecture->teacher->name ?? 'N/A' }}
                                       @else
                                       ---
                                       @endif
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
                  @endif
               </div>
            </div>
         </section>
      </div>
   </div>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
      $(document).ready(function () {
        $('#class_id').change(function () {
          $(this).closest('form').submit(); // Auto-submit form on class selection
        });
      });
   </script>

@endsection