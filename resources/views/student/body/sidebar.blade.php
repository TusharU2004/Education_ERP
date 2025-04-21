@php
   $prefix = Request::route()->getPrefix();
   $route = Route::current()->getName();
@endphp
<aside class="main-sidebar">
      <section class="sidebar">

      <div class="user-profile">
         <div class="ulogo">
            <a href="{{ route('student.dashboard') }}">
               <div class="d-flex align-items-center justify-content-center">
                  <img src="{{asset('backend/images/logo-dark.png')}}" alt="">
                  <h3>Education <b>ERP</b></h3>
               </div>
            </a>
         </div>
      </div>

         <ul class="sidebar-menu" data-widget="tree">
            
            <li class="{{ ($route == 'student.dashboard') ? 'active' : '' }}">
               <a href="{{ route('student.dashboard') }}">
                  <i data-feather="pie-chart"></i>
                  <span>Dashboard</span>
               </a>
            </li>

            <li class="treeview {{ request()->is('student.profile.*') ? 'active' : '' }}">
                <a href="#">
                    <i data-feather="user"></i> <span>Profile</span>
                    <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->routeIs('student.profile.view') ? 'active' : '' }}">
                        <a href="{{ route('student.profile.view') }}"><i class="ti-more"></i>View Profile</a>
                    </li>
                    <li class="{{ request()->routeIs('student.password.view') ? 'active' : '' }}">
                        <a href="{{ route('student.password.view') }}"><i class="ti-more"></i>Change Password</a>
                    </li>
                </ul>
            </li>

            
            <li class="treeview {{ request()->is('student.*') ? 'active' : '' }}">
                <a href="#">
                    <i data-feather="book"></i> <span>Subjects</span>
                    <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->routeIs('subject.view') ? 'active' : '' }}">
                        <a href="{{ route('subject.view') }}"><i class="ti-more"></i>View Subjects</a>
                    </li>
                     <li class="{{ request()->routeIs('subject.timetable.view') ? 'active':'' }}">
                     <a href="{{ route('subject.timetable.view') }}"><i class="ti-more"></i>View TimeTable</a>

                  </li>
                </ul>
            </li>


            <li class="treeview {{ request()->is('student.fee.*') ? 'active' : '' }}">
               <a href="#">
                  <i data-feather="credit-card"></i><span>Fee</span>
                  <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
               </a>
               <ul class="treeview-menu">
                  <li class="{{ request()->routeIs('student.fee.registration') ? 'active' : '' }}">
                     <a href="{{ route('student.fee.registration') }}"><i class="ti-more"></i>Registration Fee</a>
                  </li>

                  <li class="{{ request()->routeIs('student.fee.monthly') ? 'active' : '' }}">
                     <a href="{{ route('student.fee.monthly') }}"><i class="ti-more"></i>Monthly Fee</a>
                  </li>
               </ul>
            </li>


            <li class="treeview {{ request()->is('attendance.*') ? 'active' : '' }}">
                <a href="#">
                    <i data-feather="check-circle"></i> <span>Attendance</span>
                    <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->routeIs('attendance.view') ? 'active' : '' }}">
                        <a href="{{ route('attendance.view') }}"><i class="ti-more"></i>View Attendance</a>
                    </li>
                </ul>
            </li>

            <li class="treeview {{ request()->is('student.exam.*') ? 'active' : '' }}">
                <a href="#">
                    <i data-feather="edit"></i> <span>Exams</span>
                    <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->routeIs('student.exam.result') ? 'active' : '' }}">
                        <a href="{{  route('student.exam.result')}}"><i class="ti-more"></i>Exam Results</a>
                    </li>
                </ul>
            </li>

         </ul>
        
         <div>
            <ul class="nav">
               <li class="btn-group nav-item">
                  <a href="#" class="waves-effect waves-light nav-link rounded svg-bt-icon" data-toggle="push-menu" role="button">
                     <i class="nav-link-icon mdi mdi-menu"></i>
                  </a>
               </li>
               
               <li class="btn-group nav-item">
                  <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link rounded svg-bt-icon" title="Full Screen">
                     <i class="nav-link-icon mdi mdi-crop-free"></i>
                  </a>
               </li>
            </ul>
         </div>   
      </section>
</aside>
