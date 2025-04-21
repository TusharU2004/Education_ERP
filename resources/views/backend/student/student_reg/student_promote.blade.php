@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="content-wrapper">
        <div class="container-full">

            <section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Promote Student </h4>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col">

                                <form method="post" action="{{ route('', $editData->student_id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $editData->id }}">

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Select Year <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="year">
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Class Name <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="class">
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Last Name <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="lname" class="form-control" required=""
                                                        value="{{ $editData['student']['lname'] }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Mobile Number <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="mobile" class="form-control" required=""
                                                        value="{{ $editData['student']['mobile'] }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Address <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="address" class="form-control" required=""
                                                        value="{{ $editData['student']['address'] }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Gender <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="gender" id="gender" required="" class="form-control">
                                                        <option value="" selected="" disabled="">Select Gender</option>
                                                        <option value="Male" {{ ($editData['student']['gender'] == 'Male') ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ ($editData['student']['gender'] == 'Female') ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Religion </span></h5>
                                                <div class="controls">
                                                    <select name="religion" id="religion" class="form-control">
                                                        <option value="" selected="" disabled="">Select Religion</option>
                                                        <option value="Islam" {{ ($editData['student']['religion'] == 'Islam') ? 'selected' : '' }}>Islam</option>
                                                        <option value="Hindu" {{ ($editData['student']['religion'] == 'Hindu') ? 'selected' : '' }}>Hindu</option>
                                                        <option value="Christan" {{ ($editData['student']['religion'] == 'Christan') ? 'selected' : '' }}>Christan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Date of Birth <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="date" name="dob" class="form-control" required=""
                                                        value="{{ $editData['student']['dob'] }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Discount <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="discount" class="form-control" required=""
                                                        value="{{ $editData['discount']['discount'] }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Year <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="year_id" required="" class="form-control">
                                                        <option value="" selected="" disabled="">Select Year</option>
                                                        @foreach($years as $year)
                                                            <option value="{{ $year->id }}" {{ ($editData->year_id == $year->id) ? "selected" : "" }}>{{ $year->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Class <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="class_id" required="" class="form-control">
                                                        <option value="" selected="" disabled="">Select Class</option>
                                                        @foreach($classes as $class)
                                                            <option value="{{ $class->id }}" {{ ($editData->class_id == $class->id) ? "selected" : "" }}>
                                                                {{ $class->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Group <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="group_id" class="form-control">
                                                        <option value="" selected="" disabled="">Select Group</option>
                                                        @foreach($groups as $group)
                                                            <option value="{{ $group->id }}" {{ ($editData->group_id == $group->id) ? "selected" : "" }}>
                                                                {{ $group->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Shift <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="shift_id" required="" class="form-control">
                                                        <option value="" selected="" disabled="">Select Shift</option>
                                                        @foreach($shifts as $shift)
                                                            <option value="{{ $shift->id }}" {{ ($editData->shift_id == $shift->id) ? "selected" : "" }}>
                                                                {{ $shift->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Profile Image <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="file" name="image" class="form-control" id="image">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <img id="showImage"
                                                        src="{{ (!empty($editData['student']['image'])) ? url('upload/student_images/' . $editData['student']['image']) : url('upload/no_image.jpg') }}"
                                                        style="width: 100px; width: 100px; border: 1px solid #000000;">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="text-xs-right">
                                        <input type="submit" class="btn btn-rounded btn-info mb-5" value="Update">
                                    </div>
                                </form>

                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </section>





        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#image').change(function (e) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>



@endsection