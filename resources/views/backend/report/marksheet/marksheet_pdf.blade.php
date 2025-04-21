<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Student Marksheet</title>
   <style>
      body {
         font-family: Arial, sans-serif;
         margin: 0;
         padding: 0;
      }

      .container {
         width: 100%;
         max-width: 800px;
         margin: auto;
         padding: 20px;
         border: 1px solid #000;
      }

      .header {
         text-align: center;
         margin-bottom: 20px;
         border-bottom: 2px solid #000;
         padding-bottom: 15px;
      }

      .header img {
         width: 100px;
         height: auto;
         margin-bottom: 10px;
      }

      .header h2, .header p {
         margin: 5px 0;
      }

      .student-info {
         margin-bottom: 20px;
         border: 1px solid #000;
         padding: 10px;
         background-color: #f9f9f9;
      }

      .student-info p {
         margin: 5px 0;
      }

      .table {
         width: 100%;
         border-collapse: collapse;
         text-align: left;
      }

      .table, .table th, .table td {
         border: 1px solid #000;
      }

      .table th {
         background-color: #ddd;
         text-align: center;
      }

      .table th, .table td {
         padding: 10px;
      }

      .footer {
         margin-top: 30px;
         text-align: right;
         font-weight: bold;
         padding-right: 20px;
      }

      .total-section {
         margin-top: 20px;
         text-align: right;
         font-weight: bold;
         font-size: 16px;
      }
   </style>
</head>

<body>

   <div class="container">
      <!-- Header Section with School Info and Logo -->
      <div class="header">
         <img src="{{ public_path('upload/easyschool.png') }}" alt="School Logo" height="100px">
         <h2>Easy School ERP</h2>
         <p><strong>Address:</strong> Near Mavdi Chock, Rajkot</p>
         <p><strong>Phone:</strong> 7043169204 | <strong>Email:</strong> support@learning.com</p>
      </div>

      <!-- Student Information Section -->
      <div class="student-info">
         <p><strong>ID No:</strong> {{ $students['id_no'] }}</p>
         <p><strong>Name:</strong> {{ $students['name'] }}</p>
         <p><strong>Class:</strong> {{ $students['class'] }}</p>
         <p><strong>Year:</strong> {{ $students['year'] }}</p>
         <p><strong>Exam:</strong> {{ $students['exam'] }}</p>
      </div>

      <!-- Marks Table -->
      <table class="table">
         <thead>
            <tr>
               <th>#</th>
               <th>Subject</th>
               <th>Total Marks</th>
               <th>Marks Obtained</th>
            </tr>
         </thead>
         <tbody>
            @php 
               $totalObtained = 0; 
               $totalMaxMarks = 0;
            @endphp
            @foreach($marks as $key => $mark)
            <tr>
               <td style="text-align: center;">{{ $key + 1 }}</td>
               <td>{{ $mark['subject'] }}</td>
               <td style="text-align: center;">{{ $mark['totalmarks'] }}</td>
               <td style="text-align: center;">{{ $mark['marks'] }}</td>
               @php 
                  $totalObtained += $mark['marks'];
                  $totalMaxMarks += $mark['totalmarks'];
               @endphp
            </tr>
            @endforeach
         </tbody>
      </table>

      <!-- Total Marks & Percentage Calculation -->
      @php 
         $percentage = $totalMaxMarks > 0 ? round(($totalObtained / $totalMaxMarks) * 100, 2) : 0;
      @endphp

      <div class="total-section">
         <p><strong>Total Marks Obtained:</strong> {{ $totalObtained }} / {{ $totalMaxMarks }}</p>
         <p><strong>Percentage:</strong> {{ $percentage }}%</p>
      </div>

      <!-- Footer Section with Signature -->
      <div class="footer">
         <p>Authorized Signature</p>
      </div>
   </div>

</body>

</html>
