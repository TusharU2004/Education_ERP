@php
   $prefix = Request::route()->getPrefix();
   $route = Route::current()->getName();
@endphp

<aside class="main-sidebar">

      <div class="user-profile">
         <div class="ulogo">
            <a href="{{ route('dashboard') }}">

               <div class="d-flex align-items-center justify-content-center">
                  <img src="{{asset('upload/school_logo.png')}}" alt="">
                  <h3>Education <b>ERP</b></h3>
               </div>
            </a>
         </div>
      </div>

      <section class="sidebar">

      <ul class="sidebar-menu" data-widget="tree">

         <li class="{{ ($route == 'dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
               <i data-feather="pie-chart"></i>
               <span>Dashboard</span>
            </a>
         </li>

            @can('View Users')
               <li class="treeview {{ ($prefix == '/users') ? 'active' : '' }} ">
                  <a href="#">
                     <i data-feather="message-circle"></i>
                     <span>Manage User</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                  </a>
               
                  <ul class="treeview-menu">
                     <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}"><a href="{{ route('users.view') }}"><i class="ti-more"></i>View Users</a></li>
                  </ul>
               </li>
            @endcan

            @canany(['View Permissions','View Roles'])
               <li class="treeview {{ ($prefix == '/rolepermission') ? 'active' : '' }}">
                  <a href="#">
                     <i data-feather="grid"></i><span>Manage Role permission</span>
                     <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                  </a>
                  <ul class="treeview-menu">
                     @can('View Permissions')
                        <li class="{{ request()->routeIs('permission.*') ? 'active':'' }}"><a href="{{ route('permission.view') }}"><i class="ti-more"></i>Permissions</a></li>
                     @endcan

                     @can('View Roles')
                        <li class="{{ request()->routeIs('roles.*') ? 'active':'' }}"><a href="{{ route('roles.view') }}"><i class="ti-more"></i>Role</a></li>
                     @endcan
                  </ul>
               </li>
            @endcanany
         

            <li class="treeview {{ ($prefix == '/profile') ? 'active' : '' }}">
               <a href="#">
                  <i data-feather="grid"></i> <span>Manage Profile</span>
                  <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
               </a>
               <ul class="treeview-menu">
                  <li class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"><a href="{{ route('profile.view') }}"><i class="ti-more"></i>Your Profile</a></li>
                  <li class="{{ request()->routeIs('password.*') ? 'active' : '' }}"><a href="{{ route('password.view') }}"><i class="ti-more"></i>Change Password</a></li>
               </ul>
            </li>

         
            @canany(['Manage Classes','Manage Years','Manage Groups','Manage Shifts','Manage Fee Category','Manage Fee Category Amount','Manage Exam Type','Manage School Subjects','Manage Assign Subjects','Manage Designation'])
            <li class="treeview {{ ($prefix == '/setups') ? 'active' : '' }}">
               <a href="#">
                  <i data-feather="credit-card"></i><span>Setup Management</span>
                  <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
               </a>
               <ul class="treeview-menu">

                  @can('Manage School Logo')                    
                    <li class="{{ request()->routeIs('school.logo') ? 'active' : ''}}"><a href="{{ route('school.logo') }}"><i class="ti-more"></i>School Logo</a></li>
                  @endcan
                  
                  @can('Manage Classes')
                     <li class="{{ request()->routeIs('student.class.*') ? 'active' : '' }}"><a href="{{ route('student.class.view') }}"><i class="ti-more"></i>Student Class</a></li>
                  @endcan

                  @can('Manage Years')
                     <li class="{{ request()->routeIs('student.year.*') ? 'active' : '' }}"><a href="{{ route('student.year.view') }}"><i class="ti-more"></i>Student Year</a></li>
                  @endcan

                  @can('Manage Groups')
                  <li class="{{ request()->routeIs('student.group.*') ? 'active' : '' }}"><a href="{{ route('student.group.view') }}"><i class="ti-more"></i>Student Group</a></li>
                  @endcan

                  @can('Manage Shifts')
                  <li class="{{ request()->routeIs('student.shift.*') ? 'active' : '' }}"><a href="{{ route('student.shift.view') }}"><i class="ti-more"></i>Student Shift</a></li>
                  @endcan

                  @can('Manage Fee Category')
                  <li class="{{ request()->routeIs('fee.category.*') ? 'active' : '' }}"><a href="{{ route('fee.category.view') }}"><i class="ti-more"></i>Fee Category</a></li>
                  @endcan

                  @can('Manage Fee Category Amount')
                  <li class="{{ request()->routeIs('fee.amount.*') ? 'active' : '' }}"><a href="{{ route('fee.amount.view') }}"><i class="ti-more"></i>Fee Category Amount</a></li>
                  @endcan
                  
                  @can('Manage Exam Type')
                  <li class="{{ request()->routeIs('exam.type.*') ? 'active' : '' }}"><a href="{{ route('exam.type.view') }}"><i class="ti-more"></i>Exam Type</a></li>
                  @endcan
                
                  @can('Manage School Subjects')
                  <li class="{{ request()->routeIs('school.subject.*') ? 'active' : '' }}"><a href="{{ route('school.subject.view') }}"><i class="ti-more"></i>School Subject</a></li>
                  @endcan

                  @can('Manage Assign Subjects')
                  <li class="{{ request()->routeIs('assign.subject.*') ? 'active' : '' }}"><a href="{{ route('assign.subject.view') }}"><i class="ti-more"></i>Assign Subject</a></li>
                  @endcan

                  @can('Manage Designation')
                  <li class="{{ request()->routeIs('designation.*') ? 'active' : '' }}"><a href="{{ route('designation.view') }}"><i class="ti-more"></i>Designation </a></li>
                  @endcan
               </ul>
            </li>
            @endcanany
            
         @canany(['Manage Studnet Registration','Manage Student Roll','View Student Fee Recoards','Manage Student Attendence'])
            <li class="treeview {{ ($prefix == '/students') ? 'active' : '' }}">
               <a href="#">
                  <i data-feather="hard-drive"></i></i> <span>Student Management</span>
                  <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
               </a>
               <ul class="treeview-menu">
                  @can('Manage Student Registration')
                     <li class="{{ request()->routeIs('student.registration.*') ? 'active' : '' }}"><a href="{{ route('student.registration.view') }}"><i class="ti-more"></i>Student Registration</a></li>
                  @endcan

                  @can('Manage Student Roll')
                     <li class="{{ request()->routeIs('roll.generate.*') ? 'active' : '' }}"><a href="{{ route('roll.generate.view') }}"><i class="ti-more"></i>Roll Generate</a></li>
                  @endcan

                  @can('View Student Fee Records')
                     <li class="{{ request()->routeIs('registration.fee.*') ? 'active' : '' }}"><a href="{{ route('registration.fee.view') }}"><i class="ti-more"></i>Registration Fee </a></li>
                     <li class="{{ request()->routeIs( 'monthly.fee.*') ? 'active' : '' }}"><a href="{{ route('monthly.fee.view') }}"><i class="ti-more"></i>Monthly Fee </a></li>
                  @endcan

                  @can('Manage Student Attendence')
                     <li class="{{ request()->routeIs('student.attendance.*') ? 'active':'' }}"><a href="{{ route('student.attendance.view') }}"><i class="ti-more"></i>Student Attendance</a></li>
                  @endcan

                  @can('View Time Table')
                     <li class="{{ request()->routeIs('student.timetable.*') ? 'active':'' }}"><a href="{{ route('student.timetable.view') }}"><i class="ti-more"></i>Class Timetable</a></li>
                  @endcan
               </ul>
            </li>
         @endcanany

         @canany(['Manage Employee Registration','Manage Employee Salary','Manage Employee Salary','Manage Employee Leave','Manage Employee Attendance','Manage Employee Monthly Salary'])
            <li class="treeview {{ ($prefix == '/employees')?'active':'' }}">
               <a href="#">
                  <i data-feather="package"></i> <span>Employee Management</span>
                  <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
               </a>
               <ul class="treeview-menu">
                  @can('Manage Employee Registration')
                     <li class="{{ request()->routeIs('employee.registration.*') ? 'active' : '' }}"><a href="{{ route('employee.registration.view') }}"><i class="ti-more"></i>Employee Registration</a></li>
                  @endcan

                  @can('Manage Employee Salary')
                     <li class="{{ request()->routeIs('employee.salary.*') ? 'active' : '' }}"><a href="{{ route('employee.salary.view') }}"><i class="ti-more"></i>Employee Salary</a></li>
                  @endcan

                  @can('Manage Employee Leave')
                     <li class="{{ request()->routeIs('employee.leave.*') ? 'active' : '' }}"><a href="{{ route('employee.leave.view') }}"><i class="ti-more"></i>Employee Leave</a></li>
                  @endcan
                  
                  @can('Manage Employee Attendance')
                     <li class="{{ request()->routeIs('employee.attendance.*') ? 'active' : '' }}"><a href="{{ route('employee.attendance.view') }}"><i class="ti-more"></i>Employee Attendance</a></li>
                  @endcan

                  @can('Manage Employee Montly Salary')
                     <li class="{{ request()->routeIs('employee.monthly.*') ? 'active' : '' }}"><a href="{{ route('employee.monthly.salary') }}"><i class="ti-more"></i>Employee Monthly Salary</a></li>
                  @endcan
               </ul>
            </li>
         @endcanany

         @canany(['Marks Entry','Marks View'])
            <li class="treeview {{ ($prefix == '/marks')?'active':'' }}">
               <a href="#">
                  <i data-feather="edit-2"></i> <span> Marks Management</span>
                  <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
               </a>
               <ul class="treeview-menu">
                  @can('Marks Entry')
                     <li class="{{ request()->routeIs('marks.entry.add') ? 'active' : ''}}"><a href="{{ route('marks.entry.add') }}"><i class="ti-more"></i>Marks Entry</a></li>
                  @endcan

                  @can('Marks View')
                     <li class="{{ request()->routeIs('marks.entry.view') ? 'active':'' }}"><a href="{{ route('marks.entry.view') }}"><i class="ti-more"></i>Marks View</a></li>
                  @endcan   
               </ul>
            </li>
         @endcanany


         @can('School Account Management')
            <li class="treeview {{ ($prefix == '/accounts')?'active':'' }}">
               <a href="#">
                  <i data-feather="inbox"></i> <span> Accounts Management</span>
                  <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
               </a>
               <ul class="treeview-menu">
                     <li class="{{request()->routeIs('student.fee.*') ? 'active' : '' }}"><a href="{{ route('student.fee.view') }}"><i class="ti-more"></i>Student Fee</a></li> 
                     <li class="{{ request()->routeIs('account.salary.*') ? 'active' : ''}}"><a href="{{ route('account.salary.view') }}"><i class="ti-more"></i>Employee Salary</a></li> 
                     <li class="{{ request()->routeIs('other.cost.*') ? 'active' : '' }}"><a href="{{ route('other.cost.view') }}"><i class="ti-more"></i>Other Cost</a></li>
                  
               </ul>
            </li>
        @endcan


        @canany(['Profit Report', 'Generate Marksheet', 'Employee Attendance Report', 'Student Attendance Report', 'Student ID Card'])
         <li class="header nav-small-cap">Report Interface</li>
         <li class="treeview {{ ($prefix == '/reports')?'active':'' }}">
            <a href="#">
               <i data-feather="server"></i></i> <span> Reports Management</span>
               <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
            </a>
            <ul class="treeview-menu">
               @can('Profit Report')
                  <li class="{{request()->routeIs('monthly.profit.*') ? 'active' : '' }}"><a href="{{ route('monthly.profit.view') }}"><i class="ti-more"></i>Monthly-Yearly Profit</a></li> 
               @endcan

               @can('Generate Marksheet')
                  <li class="{{ request()->routeIs('marksheet.generate.*') ? 'active' : '' }}"><a href="{{ route('marksheet.generate.view') }}"><i class="ti-more"></i>MarkSheet Generate</a></li>
               @endcan
               
               @can('Employee Attendance Report')
                  <li class="{{ request()->routeIs('employeeattendance.report.view') ? 'active' : '' }}"><a href="{{ route('employeeattendance.report.view') }}"><i class="ti-more"></i>Employee Attendance Report</a></li>
               @endcan

               @can('Stduent Attendance Report')
                  <li class="{{ request()->routeIs('studentattendance.report.view') ? 'active' : ''}}"><a href="{{ route('studentattendance.report.view') }}"><i class="ti-more"></i>Student Attendance Report</a></li>
               @endcan

               @can('Student ID Card')
                  <li class="{{ request()->routeIs('student.idcard.*') ? 'active' : '' }}"><a href="{{ route('student.idcard.view') }}"><i class="ti-more"></i>Student ID Card </a></li>    
               @endcan
            </ul>
         </li>
         @endcanany

      </ul>
   </section>
  </aside>