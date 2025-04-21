<!DOCTYPE html>
<html>

<head>
    <title>{{ $details->student->id_no }}_monthly_receipt</title>
   <style>
      body {
         font-family: Arial, Helvetica, sans-serif;
         margin: 0;
         padding: 0;
      }

      .receipt-container {
         width: 600px;
         margin: 0 auto;
         border: 1px solid #ddd;
         padding: 20px;
      }

      .header {
         display: flex;
         align-items: center;
      }

      .header img {
         width: 200px;
         height: 100px;
         margin-right: 20px;
      }

      .header h2 {
         margin: 0;
      }

      .details-table {
         width: 100%;
         border-collapse: collapse;
         margin-top: 20px;
      }

      .details-table th,
      .details-table td {
         border: 1px solid #ddd;
         padding: 8px;
      }

      .details-table th {
         background-color: #4CAF50;
         color: white;
         text-align: left;
      }

      .footer {
         text-align: center;
         margin-top: 20px;
         font-size: 14px;
      }
   </style>
</head>

<body>
   <div class="receipt-container">
      <div class="header">
         <div>
            <img src="{{ public_path() . '/upload/easyschool.png' }}" width="400px" alt="School Logo">
         </div>
         <div>
            <h2>Easy School ERP</h2>
            <p>School Address :- Near Mavdi Chock, Rajkot </p>
            <p>Phone: 7043169204</p>
            <p>Email: support@learning.com</p>
         </div>
      </div>
      <hr>
      <h3 style="text-align: center;">Monthly Fee Payment Receipt</h3>
      <p style="text-align: center;">Month: {{ $month }}</p>
      <table class="details-table">
         <tr>
            <th>Student Details</th>
            <th>Information</th>
         </tr>
         <tr>
            <td><b>Student ID No</b></td>
            <td>{{ $details->student->id_no }}</td>
         </tr>
         <tr>
            <td><b>Roll No</b></td>
            <td>{{ $details->roll }}</td>
         </tr>
         <tr>
            <td><b>Student Full Name</b></td>
            <td>{{ $details->student->lname }} {{ $details->student->name }} {{ $details->student->fname }}</td>
         </tr>
         <tr>
            <td><b>Session</b></td>
            <td>{{ $details->student_year->name }}</td>
         </tr>
         <tr>
            <td><b>Class</b></td>
            <td>{{ $details->student_class->name }}</td>
         </tr>
         <tr>
            <td><b>Monthly Fee</b></td>
            <td>{{ $finalFee }} ₹</td>
         </tr>
         <tr>
            <td><b>Payment Date</b></td>
            <td>{{ $payment_date }}</td>
         </tr>
      </table>
      <div class="footer">
         <p></p>
         <p>Print Date: {{ date("d M Y") }}</p>
      </div>
      
   </div>
</body>

</html>