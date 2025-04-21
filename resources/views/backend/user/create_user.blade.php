@extends('admin.admin_master')
@section('admin')

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">

            <!-- Basic Forms -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Add User</h4>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">

                            <form action="{{ route('store.users') }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Name <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="name" class="form-control">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>E-mail <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="email" name="email" class="form-control">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Password <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="password" name="password" class="form-control">
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Confirm Password <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="password" name="confirm_password" class="form-control">
                                                @error('confirm_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5>Assign Roles</h5>
                                        <div class="d-flex flex-wrap gap-3">
                                            @if ($roles->isNotEmpty())
                                                @foreach ($roles as $role)
                                                   <div class="form-check">
                                                      <input type="checkbox" class="form-check-input" id="role-{{$role->id}}" name="role[]" value="{{$role->name}}">
                                                      <label class="form-check-label" for="role-{{$role->id}}">{{$role->name}}</label>
                                                   </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <input type="submit" class="btn btn-rounded btn-info" value="Submit">
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>
    </div>
</div>

@endsection
