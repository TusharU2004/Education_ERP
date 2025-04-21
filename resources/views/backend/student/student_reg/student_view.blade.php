@extends('admin.admin_master')
@section('admin')

    <div class="content-wrapper">
        <div class="container-full">

            <section class="content">
                <div class="row">

                    <div class="col-12">
                        <div class="box bb-3 border-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">Student Search</h3>
                                <a href="{{ route('student.registration.add') }}" style="float: right;"
                                    class="btn btn-rounded btn-success mb-6"> Add Student </a>
                            </div>

                            <div class="box-body">

                                <form method="GET" action="{{ route('student.registration.view') }}">

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Year <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="year_id" required="" class="form-control">
                                                        <option value="" selected="" disabled="">Select Year</option>
                                                        @foreach($years as $year)
                                                            <option value="{{ $year->id }}" {{ (@$year_id == $year->id) ? "selected" : "" }}>
                                                                {{ $year->name }}
                                                            </option>
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
                                                            <option value="{{ $class->id }}" {{ (@$class_id == $class->id) ? "selected" : "" }}>
                                                                {{ $class->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="padding-top: 25px;">
                                            <input type="submit" class="btn btn-rounded btn-dark mb-5" value="Search">
                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    @if(!empty($allData))
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">

                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="5%">SL</th>
                                                    <th>Name</th>
                                                    <th>ID No</th>
                                                    <th>Roll</th>
                                                    <th>Year</th>
                                                    <th>Class</th>
                                                    <th>Image</th>
                                                    <th width="25%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($allData as $key => $student)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td> {{ $student->student->name }}</td>
                                                        <td> {{ $student->student->id_no }}</td>
                                                        <td> {{ $student->roll }} </td>
                                                        <td> {{ $student->student_year->name }}</td>
                                                        <td> {{ $student->student_class->name }}</td>
                                                        <td>
                                                            <img src="{{ (!empty($student->student->image)) ? url('upload/student_images/' . $student->student->image) : url('upload/no_image.jpg') }}"
                                                                style="width: 50px; width: 50px;">
                                                        </td>
                                                        <td>
                                                            <a title="Edit"
                                                                href="{{ route('student.registration.edit', $student->student_id) }}"
                                                                class="btn btn-info">
                                                                <i class="fa fa-edit"></i>
                                                            </a>

                                                            <a target="_blank" title="Details"
                                                                href="{{ route('student.registration.details', $student->student_id) }}"
                                                                class="btn btn-primary">
                                                                <i class="fa fa-eye"></i>
                                                            </a>

                                                            <a title="inactive"
                                                                href="{{ route('student.inactive', $student->student_id) }}"
                                                                class="btn btn-danger">
                                                                <i class="fa fa-eye-slash"></i>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>

@endsection