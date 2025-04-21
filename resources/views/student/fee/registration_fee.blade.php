@extends('student.student_master')
@section('student')

    <div class="content-wrapper">
        <div class="container-full">

            <section class="content">
                <h2>Student Assign Suject List</h2>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <tr>
                                <th>Student Name</th>
                                <td>{{ $student->student->name }}</td>
                            </tr>
                            <tr>
                                <th>Class</th>
                                <td>{{ $student->student_class->name }}</td>
                            </tr>
                            <tr>
                                <th>Year</th>
                                <td>{{ $student->student_year->name }}</td>
                            </tr>
                            <tr>
                                <th>Registration Fee</th>
                                <td>
                                    ₹{{ $final_registration_fee }}

                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($registration_fee_paid)
                                        <span class="badge badge-success">Paid</span>
                                    @else
                                        <span class="badge badge-danger">Not Paid</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>


@endsection