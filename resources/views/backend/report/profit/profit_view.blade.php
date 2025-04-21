@extends('admin.admin_master')
@section('admin')

    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="box bb-3 border-warning">
                    <div class="box-header">
                        <h4 class="box-title">Manage <strong>Monthly/Yearly Profit</strong></h4>
                    </div>

                    <div class="box-body">
                        <form action="{{ route('monthly.profit.view') }}" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>Start Date <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="date" name="start_date"  class="form-control" value="{{ request('start_date') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>End Date <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4" style="padding-top: 25px;">
                                    <input type="submit" value="Search" class="btn btn-rounded btn-dark mb-5">
                                </div>
                            </div>
                        </form>

                        @if (!empty($data))
                            <div class="chart-container mt-4" style="width: 40%; margin: auto;">
                                <canvas id="profitPieChart"></canvas>
                            </div>

                            <div class="text-center mt-4">
                                <h5><strong>Total Cost:</strong> {{ $data['total_cost'] }} ₹</h5>
                                <h5><strong>Profit:</strong> {{ $data['profit'] }} ₹</h5>

                                <a class="btn btn-sm btn-success mt-3" title="PDF" target="_blank"
                                    href="{{ route('report.profit.pdf', ['start_date' => $start_date, 'end_date' => $end_date]) }}">
                                    Download PDF
                                </a>
                            </div>

                            <!-- Chart.js CDN -->
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                            <script>
                                const ctx = document.getElementById('profitPieChart').getContext('2d');
                                const profitChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: ['Student Fee', 'Other Cost', 'Employee Salary'],
                                        datasets: [{
                                            label: 'Amount in ₹',
                                            data: [
                                      {{ $data['fee'] }},
                                      {{ $data['other_cost'] }},
                                                {{ $data['salary'] }}
                                            ],
                                            backgroundColor: [
                                                '#4CAF50', // Student Fee - Green
                                                '#FFC107', // Other Cost - Amber
                                                '#F44336'  // Employee Salary - Red
                                            ],
                                            borderColor: '#fff',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            title: {
                                                display: true,
                                                text: 'Monthly/Yearly Profit Analysis'
                                            },
                                            legend: {
                                                position: 'bottom'
                                            }
                                        }
                                    }
                                });
                            </script>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection