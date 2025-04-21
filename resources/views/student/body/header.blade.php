<header class="main-header">
   <!-- Header Navbar -->
   <nav class="navbar navbar-static-top pl-30">
      <!-- Sidebar toggle button-->
      <div>

      </div>

      <div class="navbar-custom-menu r-side">
         <ul class="nav navbar-nav">
            <!-- full Screen -->
            <!-- Notifications -->

            @php
            $user = DB::table('users')->where('id', Auth::user()->id)->first();
         @endphp
            <!-- User Account-->
            <li class="dropdown user user-menu">
               <a href="#" class="waves-effect waves-light rounded dropdown-toggle p-0" data-toggle="dropdown"
                  title="User">
                  <img
                     src="{{ (!empty($user->image)) ? url('upload/student_images/' . $user->image) : url('upload/no_image.jpg') }}"
                     alt="">
               </a>
               <ul class="dropdown-menu animated flipInX">
                  <li class="user-body">
                     <a class="dropdown-item" href="{{ route('student.profile.view') }}"><i class="ti-user text-muted mr-2"></i>
                        Profile</a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="{{ route('student.logout') }}"><i class="ti-lock text-muted mr-2"></i>
                        Logout</a>
                  </li>
               </ul>
            </li>
         </ul>
      </div>
   </nav>
</header>