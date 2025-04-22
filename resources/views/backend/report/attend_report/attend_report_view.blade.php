@extends('admin.admin_master')
@section('admin')

    <div class="content-wrapper">
        <div class="container-full">

            <section class="content">

                <div class="box bb-3 border-warning">
                    <div class="box-header">
                        <h4 class="box-title">Manage <strong>Employee Attendance Report</strong></h4>
                    </div>

                    <div class="box-body">
                        <form method="GET" action="{{ route('report.employeeattendance.get') }}">

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>Month & Year<span class="text-danger"> *</span></h5>
                                        <div class="controls">
                                            <input type="month" name="date" class="form-control" required="" value="{{ request('date') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4" style="padding-top: 25px;">
                                    <input type="submit" class="btn btn-rounded btn-dark mb-5" value="Search">
                                </div>

                            </div>

                        </form>
                        @if(isset($graphData) && count($graphData) > 0)
                            <hr>
                            <h4>Employee Attendance Summary - {{ $month }}</h4>
                            <div class="row">
                                @foreach($graphData as $data)
                                    <div class="col-md-4 mb-4 text-center">
                                        <h5>{{ $data['name'] }}</h5>
                                        <canvas id="pieChart_{{ $loop->index }}" height="200"></canvas>
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
                                                    'rgba(54, 162, 235, 0.7)',
                                                    'rgba(255, 99, 132, 0.7)',
                                                    'rgba(255, 206, 86, 0.7)'   // Holiday
                                                ],
                                                borderColor: [
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 99, 132, 1)',
                                                    'rgba(255, 206, 86, 1)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                title: {
                                                    display: false
                                                },
                                                legend: {
                                                    position: 'bottom'
                                                }
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