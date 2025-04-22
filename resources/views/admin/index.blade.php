@extends('admin.admin_master')
@section('admin')

<div class="content-wrapper">
    <div class="container-full">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xl-12 col-12">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16 text-center">Dashboard</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @can('Manage Employee Registration')
                    <!-- Total Employees -->
                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-primary-light rounded w-60 h-60">
                                    <i class="text-primary mr-0 font-size-24 mdi mdi-account-multiple"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">Total Employee</p>
                                    <h3 class="text-white mb-0 font-weight-500">{{ $staff }}</h3>
                                    <a href="{{ route('employee.registration.add') }}" class="btn btn-rounded btn-info mb-5">Add Employee</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('Manage Student Registration')
                    <!-- Total Students -->
                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-warning-light rounded w-60 h-60">
                                    <i class="text-warning mr-0 font-size-24 mdi mdi-account-plus"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">Total Students</p>
                                    <h3 class="text-white mb-0 font-weight-500">{{ $student }}</h3>
                                    <a href="{{ route('student.registration.add') }}" class="btn btn-rounded btn-info mb-5">Add Student</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('School Account Management')
                    <!-- Monthly Profit -->
                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-info-light rounded w-60 h-60">
                                    <i class="text-info mr-0 font-size-24 mdi mdi-cash-multiple"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">Total Profit This Month</p>
                                    <h3 class="text-white mb-0 font-weight-500">{{ $profit }}₹</h3>
                                    <a href="{{ route('monthly.profit.view',[
                                        'start_date' => \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'),
                                        'end_date' => \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')
                                    ]) }}" class="btn btn-rounded btn-info mb-5">View Account Report</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-danger-light rounded w-60 h-60">
                                    <i class="text-danger mr-0 font-size-24 mdi mdi-chart-areaspline"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">Total Expenses</p>
                                    <h3 class="text-white mb-0 font-weight-500">{{ $otherCost }}₹</h3>
                                    <a href="{{ route('other.cost.view') }}" class="btn btn-rounded btn-danger mb-5">View Expenses</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                

                @can('Manage Employee Attendance')
                    <!-- Today's Attendance -->
                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-secondary-light rounded w-60 h-60">
                                    <i class="text-secondary mr-0 font-size-24 mdi mdi-calendar-check"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">Employee Attendance Report</p>
                                    <h3 class="text-white mb-0 font-weight-500"> Overview </h3>
                                    <a href="{{ route('report.employeeattendance.get',['date'=>date('Y-m')]) }}" class="btn btn-rounded btn-secondary mb-5">View Attendance</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('Manage Student Attendence')
                    <!-- View Reports -->
                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-indigo-light rounded w-60 h-60">
                                    <i class="text-indigo mr-0 font-size-24 mdi mdi-file-chart"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">Student Attendance Reports</p>
                                    <h3 class="text-white mb-0 font-weight-500">Overview</h3>
                                    <a href="{{ route('studentattendance.report.view',['date'=>date('Y-m')]) }}" class="btn btn-rounded btn-info mb-5">View Reports</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('Send Notification')
                    <!-- Notification -->
                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-teal-light rounded w-60 h-60">
                                    <i class="text-teal mr-0 font-size-24 mdi mdi-bell-ring"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">Notify Users</p>
                                    <h3 class="text-white mb-0 font-weight-500">Send Alerts</h3>
                                    <a href="{{ route('notification.create') }}" class="btn btn-rounded btn-warning mb-5">Send Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

            </div>

        </section>
        <!-- /.content --> 
    </div>
</div>

@endsection
