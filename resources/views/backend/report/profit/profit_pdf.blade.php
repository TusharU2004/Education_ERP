<!DOCTYPE html>
<html>

<head>
   <style>
      #customers {
         font-family: Arial, Helvetica, sans-serif;
         border-collapse: collapse;
         width: 100%;
      }

      #customers td,
      #customers th {
         border: 1px solid #ddd;
         padding: 8px;
      }

      #customers tr:nth-child(even) {
         background-color: #f2f2f2;
      }

      #customers tr:hover {
         background-color: #ddd;
      }

      #customers th {
         padding-top: 12px;
         padding-bottom: 12px;
         text-align: left;
         background-color: #4CAF50;
         color: white;
      }
      .receipt-container { 
         width: 600px; 
         margin: 0 auto; 
         border: 6px solid #ddd; 
         padding: 20px;
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
         <p>School Address :- Near Mavdi Chock, Rajkot</p>
         <p>Phone: 7043169204</p>
         <p>Email: support@learning.com</p>
      </div>
   </div>
   <h3 style="text-align: center;">Monthly and Yearly Profit</h3>

   <table id="customers">
      <tr>
         <td colspan="2" style="text-align: center;">
            <h4>Reporting Date: {{ date('d M Y', strtotime($start_date)) }} - {{ date('d M Y', strtotime($end_date)) }}</h4>
         </td>
      </tr>
      <tr>
         <td width="50%">
            <h4>Purpose</h4>
         </td>
         <td width="50%">
            <h4>Amount</h4>
         </td>

      </tr>
      <tr>
         <td>Student Fee </td>
         <td> {{ $student_fee }}</td>

      </tr>

      <tr>
         <td>Employee Salary </td>
         <td> {{ $emp_salary }} </td>

      </tr>

      <tr>
         <td>Other Cost </td>
         <td> {{ $other_cost }} </td>

      </tr>
      <tr>
         <td>Total Cost</td>
         <td> {{ $total_cost }} </td>

      </tr>

      <tr>
         <td>Profit </td>
         <td>{{ $profit }}</td>

      </tr>


   </table>
   <br> <br>
   <i style="font-size: 10px; float: right;">Print Data : {{ date("d M Y") }}</i>

   <hr style="border: dashed 2px; width: 95%; color: #000000; margin-bottom: 50px">

</div>
</body>

</html>