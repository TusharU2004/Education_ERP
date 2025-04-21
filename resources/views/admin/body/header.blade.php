<header class="main-header">
    <!-- Header Navbar -->

    <nav class="navbar navbar-static-top pl-30">
        <!-- Sidebar toggle button-->
        <div>
            <ul class="nav">
                <li class="btn-group nav-item">
                    <a href="#" class="waves-effect waves-light nav-link rounded svg-bt-icon" data-toggle="push-menu"
                        role="button">
                        <i class="nav-link-icon mdi mdi-menu"></i>
                    </a>
                </li>
                <li class="btn-group nav-item">
                    <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link rounded svg-bt-icon"
                        title="Full Screen">
                        <i class="nav-link-icon mdi mdi-crop-free"></i>
                    </a>
                </li>
            </ul>
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
                        @php
                            $employeePath = public_path('upload/employee_images/' . $user->image);
                            $studentPath = public_path('upload/student_images/' . $user->image);
                            $userPath = public_path('upload/user_images/'. $user->image);

                            if (!empty($user->image) && file_exists($employeePath))
                            {
                                $imgPath = url('upload/employee_images/' . $user->image);
                            } 
                            elseif (!empty($user->image) && file_exists($studentPath)) 
                            {
                                $imgPath = url('upload/student_images/' . $user->image);
                            }
                            elseif(!empty($user->image) && file_exists($userPath))
                            {
                                $imgPath = url('upload/user_images/'. $user->image);
                            }
                            else{
                                $imgPath = url('upload/no_image.jpg');
                            }
                        
                        @endphp

                        <img src="{{ $imgPath }}" alt="User Image">

                    </a>
                    <ul class="dropdown-menu animated flipInX">
                        <li class="user-body">
                            <a class="dropdown-item" href="{{ route('profile.view') }}"><i
                                    class="ti-user text-muted mr-2"></i>
                                Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"><i
                                    class="ti-lock text-muted mr-2"></i>
                                Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>