<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">
   <link rel="icon" href="{{asset('backend/images/favicon.ico')}}">

   <title>Education ERP System - Dashboard</title>

   <link rel="stylesheet" href="{{ asset('backend/css/vendors_css.css') }}">

   <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('backend/css/skin_color.css') }}">

   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-V1L3K6DvH0PUM0Qz0Jw5kD2i0Xwv5YkDXH7wl+f7dKH1D6BkF2Z/0fjh2sH3S7K8l5oFoJw3xzybYu+1ZXzFug==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

   <div class="wrapper">

      @include('student.body.header')

      @include('student.body.sidebar')

      @yield('student')

      @include('student.body.footer')

      <div class="control-sidebar-bg"></div>

   </div>


   <!-- Vendor JS -->
   <script src="{{ asset('backend/js/vendors.min.js') }}"></script>
   <script src="{{ asset('../assets/icons/feather-icons/feather.min.js') }}"></script>
   <script src="{{ asset('../assets/vendor_components/easypiechart/dist/jquery.easypiechart.js') }}"></script>
   <script src="{{ asset('../assets/vendor_components/apexcharts-bundle/irregular-data-series.js') }}"></script>
   <script src="{{ asset('../assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>


   <script src="{{asset('../assets/vendor_components/datatable/datatables.min.js')}}"></script>
   <script src="{{asset('backend/js/pages/data-table.js')}}"></script>


   <script src="{{ asset('backend/js/template.js') }}"></script>
   <script src="{{ asset('backend/js/pages/dashboard.js') }}"></script>


   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>

</html>