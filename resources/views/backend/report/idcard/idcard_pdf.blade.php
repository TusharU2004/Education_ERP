<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Student ID Card</title>

   <style>
      body {
         font-family: Arial, sans-serif;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         margin: 0;
         background-color: #f4f4f4;
      }

      .id-card {
         width: 320px;
         height: auto;
         border: 2px solid #000;
         text-align: center;
         padding: 20px;
         border-radius: 10px;
         background: #fff;
         box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
      }

      .id-header img {
         width: 80px;
         height: auto;
      }

      .id-header h4 {
         margin-top: 5px;
         font-size: 20px;
         font-weight: bold;
      }

      .id-photo img {
         width: 100px;
         height: 100px;
         border-radius: 50%;
         border: 2px solid #000;
         margin-top: 10px;
      }

      .id-details {
         text-align: left;
         margin-top: 10px;
      }

      .id-details p {
         font-size: 14px;
         margin: 5px 0;
         padding-left: 10px;
      }

      .id-footer {
         margin-top: 15px;
         font-weight: bold;
      }
   </style>
</head>

<body>

   <div class="id-card">

      <!-- School Logo -->
      <div class="id-header">
         <img src="{{ public_path('upload/easyschool.png') }}" alt="School Logo">
         <h4>Easy School ERP</h4>
      </div>

      <!-- Student Photo -->
      <div class="id-photo">
         @if (!empty($student->student->image) && file_exists(public_path('upload/student_images/' . $student->student->image)))
          <img src="{{ public_path('upload/student_images/' . $student->student->image) }}" alt="Student Photo">
       @endif
      </div>

      <!-- Student Details -->
      <div class="id-details">
         <p><strong>ID No:</strong> {{ $student->student->id_no }}</p>
         <p><strong>Name:</strong> {{ $student->student->lname }} {{ $student->student->name }}
            {{ $student->student->fname }}
         </p>
         <p><strong>Class:</strong> {{ $student->student_class->name }}</p>
         <p><strong>Year:</strong> {{ $student->student_year->name }}</p>
         <p><strong>Mobile No:</strong> {{ $student->student->mobile }}</p>
      </div>

      <!-- Signature & Footer -->
      <div class="id-footer">
         <p>Authorized Signature</p>
      </div>
   </div>

</body>

</html>