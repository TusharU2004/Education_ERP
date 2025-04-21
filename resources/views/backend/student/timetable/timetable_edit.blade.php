@extends('admin.admin_master')

@section('admin')
   <div class="content-wrapper">
      <div class="container-full">
        <section class="content">
          <div class="box bb-3 border-warning">
            <div class="box-header">
               <h4 class="box-title">Update Class Time Table</h4>
            </div>

            <div class="box-body">

               <form action="{{ route('student.timetable.update',$editData->id) }}" method="post">
                  @csrf

                  <div class="row">

                     <div class="col-md-3">
                        <div class="form-group">
                           <h5>Class <span class="text-danger">*</span></h5>
                           <div class="controls">
                              <select name="class_id" id="class_id" required class="form-control">
                                 <option value="" selected disabled>Select Class</option>
                                 @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ @($class->id == $editData->class_id) ? 'selected':'' }} >{{ $class->name }}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="form-group">
                           <h5>Subject <span class="text-danger">*</span></h5>
                           <div class="controls">
                              <select name="subject_id" id="subject_id" required class="form-control">
                                 <option value="" selected disabled>Select Subject</option>
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-2">
                        <div class="form-group">
                           <h5>Day <span class="text-danger">*</span></h5>
                           <input type="text" name="day" class="form-control" value="{{ $editData->day }}" required placeholder="e.g., Monday">
                        </div>
                     </div>

                     <div class="col-md-2">
                        <div class="form-group">
                           <h5>Start Time <span class="text-danger">*</span></h5>
                           <input type="time" name="start_time" class="form-control" value="{{ $editData->start_time }}" required>
                        </div>
                     </div>

                     <div class="col-md-2">
                        <div class="form-group">
                           <h5>End Time <span class="text-danger">*</span></h5>
                           <input type="time" name="end_time" class="form-control" value="{{ $editData->end_time }}" required>
                        </div>
                     </div>
                     
                     
                  </div>
                  <div class="d-flex justify-content-center mt-3">
                        <input type="submit" class="btn btn-info" value="Save Timetable">
                     </div>
               </form>
               
            </div>
         </div>
        </section>
      </div>
   </div>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
    $(document).ready(function () {
        function fetchSubjects(class_id, selected_subject_id = null) {
            if (class_id) {
                $.ajax({
                    url: "{{ route('marks.getsubject') }}",
                    type: "GET",
                    data: { class_id: class_id },
                    success: function (data) {
                        $('#subject_id').empty();
                        $('#subject_id').append('<option value="" selected disabled>Select Subject</option>');

                        $.each(data, function (key, subject) {
                            let isSelected = selected_subject_id == subject.subject_id ? 'selected' : '';
                            $('#subject_id').append(`<option value="${subject.subject_id}" ${isSelected}>${subject.school_subject.name}</option>`);
                        });
                    }
                });
            }
        }

        $('#class_id').change(function () {
            var class_id = $(this).val();
            fetchSubjects(class_id);
        });

        // Load subjects on edit mode if class is pre-selected
        var selectedClassId = $('#class_id').val();
        var selectedSubjectId = "{{ $editData->subject_id ?? '' }}"; // Retain previous selection
        if (selectedClassId) {
            fetchSubjects(selectedClassId, selectedSubjectId);
        }
    });
</script>
   
@endsection
