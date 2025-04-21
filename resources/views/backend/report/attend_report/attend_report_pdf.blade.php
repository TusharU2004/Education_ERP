<!DOCTYPE html>
<html>

<head>
    <title>Employee Attendance Report</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: auto;
            text-align: center;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header img {
            width: 80px;
            height: auto;
        }

        .header-text {
            text-align: center;
        }

        .header h2 {
            margin: 5px 0;
        }

        .header p {
            margin: 3px 0;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        #customers th,
        #customers td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        #customers th {
            background-color: #4CAF50;
            color: white;
        }

        #customers tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: right;
        }

        hr {
            border: dashed 2px;
            width: 95%;
            color: #000;
            margin-bottom: 50px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <img src="{{ public_path('upload/easyschool.png') }}" alt="School Logo" height="100px">
            <div class="header-text">
                <h2>Easy School ERP</h2>
                <p><strong>Address:</strong> Near Mavdi Chock, Rajkot</p>
                <p><strong>Phone:</strong> 7043169204 | <strong>Email:</strong> support@learning.com</p>
            </div>
        </div>

        @php
            $totalDays = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($month)), date('Y', strtotime($month)));
        @endphp

        <h4 class="report-title">Employee Attendance Report - {{ $month }}</h4>

        <!-- Attendance Table -->
        <table id="customers">
            <tr>
                <th>Employee Name</th>
                @for($day = 1; $day <= $totalDays; $day++)
                    @php
                        $date = date('Y-m-d', strtotime("$month-$day"));
                    @endphp
                    <th>{{ $day }}</th>
                @endfor
                <th>Total Present</th>
                <th>Total Absent</th>
            </tr>

            @foreach($employeeAttendanceData as $emp)
                @php
                    $presentCount = 0;
                    $absentCount = 0;
                @endphp
                <tr>
                    <td>{{ $emp['employee']->lname }} {{ $emp['employee']->name }}</td>
                    @for($day = 1; $day <= $totalDays; $day++)
                        @php
                            $date = date('Y-m-d', strtotime("$month-$day"));
                            $isSunday = date('N', strtotime($date)) == 7;
                            $status = $emp['attendance'][$day] ?? '-';

                            if ($isSunday && !isset($emp['attendance'][$day])) {
                                $status = 'H';
                            }

                            if ($status === 'P') {
                                $presentCount++;
                            } elseif ($status === 'A') {
                                $absentCount++;
                            }
                        @endphp
                        <td>{{ $status }}</td>
                    @endfor
                    <td><strong>{{ $presentCount }}</strong></td>
                    <td><strong>{{ $absentCount }}</strong></td>
                </tr>
            @endforeach
        </table>

        <div class="footer">
            <i>Print Date: {{ date("d M Y") }}</i>
        </div>

        <hr>

    </div>

</body>

</html>
