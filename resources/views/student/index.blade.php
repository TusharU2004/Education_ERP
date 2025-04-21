@extends('student.student_master')
@section('student')

    <div class="content-wrapper">
        <div class="container-full">
            <div class="container-full px-4 py-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-primary">Student Dashboard</h2>
                </div>

                <div class="row g-4">

                    <!-- Profile Card -->
                    <div class="col-md-4">
                        <div class="card shadow rounded-4 border-0">
                            <div class="card-body text-center">
                                <img src="{{ asset('upload/student_images/' . Auth::user()->image) }}"
                                    class="rounded-circle mb-3" width="80" height="80" alt="Student">
                                <h5 class="card-title">{{ Auth::user()->name }}</h5>
                                <p class="card-text text-muted">{{ Auth::user()->email }}</p>
                                <a href="{{ route('student.profile.view') }}" class="btn btn-outline-primary btn-sm">View
                                    Profile</a>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Status -->
                    <div class="col-md-4">
                        <div class="card shadow rounded-4 border-start border-4 border-success">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Monthly Fee</h6>
                                <h3 class="card-title text-success">₹{{ number_format($total_paid ?? 0, 2) }}</h3>
                                <p class="mb-1">Paid This Year</p>
                                <a href="{{ route('student.fee.monthly') }}" class="btn btn-sm btn-success">Pay Fee</a>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Summary -->
                    <div class="col-md-4">
                        <div class="card shadow rounded-4 border-start border-4 border-info">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Attendance</h6>
                                <h3 class="card-title text-info">{{ $attendance_percentage ?? '0%' }}</h3>
                                <p class="mb-1">This Month</p>
                                <a href="{{ route('attendance.view') }}" class="btn btn-sm btn-info">View Attendance</a>
                            </div>
                        </div>
                    </div>

                    <!-- Marks -->
                    <div class="col-md-4">
                        <div class="card shadow rounded-4 border-start border-4 border-warning">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Recent Marks</h6>
                                <h3 class="card-title text-warning">{{ $recent_marks ?? 'N/A' }}</h3>
                                <p class="mb-1">Subject {{ $subject ?? 'N/A' }}</p>
                                <a href="{{ route('student.exam.result') }}" class="btn btn-sm btn-warning">View Marks</a>
                            </div>
                        </div>
                    </div>

                    <!-- Subject List -->
                    <div class="col-md-4">
                        <div class="card shadow rounded-4 border-start border-4 border-danger">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Subjects</h6>
                                <h3 class="card-title text-danger">{{ $subject_count ?? '0' }}</h3>
                                <p class="mb-1">Total Subjects</p>
                                <a href="{{ route('subject.view') }}" class="btn btn-sm btn-danger">View
                                    Subjects</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card shadow rounded-4 border-start border-4 border-primary">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Today's Timetable ({{ $today }})</h6>

                                @if(count($timetable) > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach($timetable as $time => $entry)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $time }}</strong>
                                                    <span class="text-muted"> -
                                                        {{ $entry->subject->name ?? 'N/A' }}</span>
                                                </div>
                                                <span class="badge bg-primary">{{ $entry->end_time }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted mt-2">No classes scheduled for today.</p>
                                @endif
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

@endsection