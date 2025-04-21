<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Salary Receipt</title>
   <style>
      body {
         font-family: Arial, sans-serif;
         margin: 10px;
         padding: 10px;
      }

      .container {
         width: 100%;
         max-width: 800px;
         margin: auto;
         padding: 10px;
         border: 1px solid #ddd;
      }

      .header {
         display: flex;
         justify-content: space-between;
         align-items: center;
      }

      .header img {
         width: 40px;
      }

      .title {
         text-align: center;
         font-size: 22px;
         font-weight: bold;
      }

      .section {
         margin-top: 20px;
         padding: 10px;
         border: 1px solid #ddd;
      }

      .section h5 {
         margin-bottom: 7px;
         font-size: 18px;
      }

      .section p {
         margin: 5px 0;
         font-size: 16px;
      }

      .total {
         text-align: center;
         font-size: 20px;
         font-weight: bold;
         margin-top: 15px;
      }

      .signature {
         text-align: right;
         margin-top: 15px;
         margin-left: 10px;
      }

      .signature p {
         font-size: 16px;
         margin-bottom: 20px;
      }
   </style>
</head>

<body>

   <div class="container">

      <div class="header">
         <div>
            <img src="{{ public_path() . '/upload/easyschool.png' }}" width="300px" alt="School Logo">
         </div>
         <div>
            <h2>Easy School ERP</h2>
            <p>School Address :- Near Mavdi Chock, Rajkot</p>
            <p>Phone: 7043169204</p>
            <p>Email: support@learning.com</p>
         </div>
      </div>

      <hr>

      <div class="section">
         <h5>Employee Details:</h5>
         <p><strong>Name:</strong> {{ $details->user->lname }} {{ $details->user->name }}</p>
         <p><strong>Employee ID:</strong> {{ $details->user->id_no }}</p>
         <p><strong>Designation:</strong> {{ $details->user->designation->name ?? 'N/A' }}</p>
         <p><strong>Receipt Date:</strong> {{ date('d-m-Y', strtotime($details->date)) }}</p>
      </div>

      <div class="section">
         <h5>Payment Details:</h5>
         <p><strong>Salary Month:</strong> {{ date('F Y', strtotime($details->date)) }}</p>
         <p><strong>Basic Salary:</strong> ₹{{ number_format($details->user->salary, 2) }}</p>
         <p><strong>Paid Amount:</strong> ₹{{ number_format($details->amount, 2) }}</p>
      </div>

      <div class="total">
         <p>Total Paid: ₹{{ number_format($details->amount, 2) }}</p>
      </div>

      <div class="signature">
         <p><strong>Authorized Signature</strong></p>
         <p>______________________</p>
      </div>

   
   <div class="row">
      <div class="col-12 text-right">
         <p><strong>Printed On:</strong> {{ date('d-m-Y') }}</p>
      </div>
   </div>
</div>
</body>

</html>