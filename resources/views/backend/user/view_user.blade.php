@extends('admin.admin_master')
@section('admin')

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="row">

                <div class="col-12">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">User List</h3>
                            <a href="{{ route('users.create') }}" style="float: right;"
                                class="btn btn-rounded btn-success mb-5">
                                Add User
                            </a>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">SL</th>
                                            <th>designation</th>
                                            <th>Role</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th width="25%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ optional($user->designation)->name }}</td>
                                            <td>{{$user->roles->pluck('name')->implode(',')}}</td>
                                            <td>{{ $user->lname }} {{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @can('Edit User')
                                                <a href="{{ route('users.edit', Crypt::encrypt($user->id)) }}"
                                                    class="btn btn-info btn-sm">Edit</a>
                                                @endcan
                                                @can('Delete User')
                                                <a href="{{ route('delete.users', $user->id) }}" class="btn btn-danger btn-sm"
                                                    id="delete">Delete</a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection