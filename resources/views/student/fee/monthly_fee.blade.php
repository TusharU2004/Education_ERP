@extends('student.student_master')
@section('student')

    <div class="content-wrapper">
        <div class="container-full">

            <section class="content">
                <h2>Student Assign Suject List</h2>
                <div class="row">
                    <div class="col-12">
                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($months as $month)
                                        <tr>
                                            <td>{{ $month['month_name'] }}</td>
                                            <td>
                                                @if ($month['is_paid'])
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <span class="badge bg-danger">Unpaid</span>
                                                @endif
                                            </td>
                                            <td>₹{{ number_format($month['fee'], 2) }}</td>
                                            <td>
                                                @if (!$month['is_paid'])
                                                    <form action="{{ route('student.pay.monthly.fee') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="month" value="{{ $month['month_number'] }}">
                                                        <input type="hidden" name="amount" value="{{ $month['fee'] }}">
                                                        <input type="submit" class="btn btn-primary btn-sm" value="Pay Now">
                                                    </form>
                                                @else
                                                <a href="{{ route('student.view.receipt', ['month' => $month['month_number']]) }}" class="btn btn-success btn-sm" target="_blank">View Receipt</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


@endsection