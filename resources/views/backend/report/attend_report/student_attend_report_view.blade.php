@extends('admin.admin_master')
@section('admin')

    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="box bb-3 border-warning">
                    <div class="box-header">
                        <h4 class="box-title"> <strong>Student Attendance Report</strong></h4>
                    </div>

                    <div class="box-body">
                        <form method="GET" action="{{ route('report.studentattendance.get') }}">

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>Class Name <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <select name="class_id" required="" class="form-control">
                                                <option value="" selected="" disabled="">Select Class</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" {{ @($class->id == $class_id) ? 'selected' : ''}}>
                                                        {{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>Month & Year <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="month" name="date" class="form-control" required=""
                                                value="{{ request('date') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1" style="padding-top: 25px;">
                                    <input type="submit" class="btn btn-rounded btn-dark mb-5" value="Search">
                                </div>
                            </div>
                        </form>
                        @if(isset($graphData) && count($graphData) > 0)
                            <hr>
                            <h4>Student Attendance - {{ $month }}</h4>
                            <div class="row">
                                @foreach($graphData as $data)
                                    <div class="col-md-4 text-center mb-4">
                                        <h5>{{ $data['name'] }}</h5>
                                        <canvas id="pieChart_{{ $loop->index }}" height="100"></canvas>
                                    </div>
                                @endforeach
                            </div>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                                @foreach($graphData as $index => $data)
                                    new Chart(document.getElementById('pieChart_{{ $index }}').getContext('2d'), {
                                        type: 'pie',
                                        data: {
                                            labels: ['Present', 'Absent', 'Holiday'],
                                            datasets: [{
                                                data: [{{ $data['present'] }}, {{ $data['absent'] }}, {{ $data['holiday'] }}],
                                                backgroundColor: [
                                                    'rgba(75, 192, 192, 0.7)',
                                                    'rgba(255, 99, 132, 0.7)',
                                                    'rgba(255, 206, 86, 0.7)'
                                                ],
                                                borderColor: [
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(255, 99, 132, 1)',
                                                    'rgba(255, 206, 86, 1)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                legend: { position: 'bottom' }
                                            }
                                        }
                                    });
                                @endforeach
                            </script>
                        @endif

                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection