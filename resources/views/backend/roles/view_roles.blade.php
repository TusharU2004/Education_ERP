@extends('admin.admin_master')
@section('admin')

    <div class="content-wrapper">
        <div class="container-full">

            <section class="content">
                <div class="row">
                    <div class="col-12">

                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Roles List</h3>
                                @can('Create Roles')
                                    <a href="{{ route('roles.create') }}" style="float: right;"
                                        class="btn btn-rounded btn-success mb-5"> Create Role</a>
                                @endcan
                            </div>

                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">SL</th>
                                                <th>Name</th>
                                                <th>Permission</th>
                                                <th>created_at</th>
                                                @canany(['Edit Roles', 'Delete Roles'])
                                                    <th width="25%">Action</th>
                                                @endcanany
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$role->name}}</td>
                                                    <td>{{$role->permissions->pluck('name')->implode(', ')}}</td>
                                                    <td>{{Carbon\Carbon::parse($role->created_at)->diffForHumans()}}</td>
                                                    @canany(['Edit Roles', 'Delete Roles'])
                                                        <td class="col-sm-3 p-3">
                                                            @can('Edit Roles')
                                                                <a class="btn btn-info btn-sm"
                                                                    href="{{Route('roles.edit', $role->id)}}">Edit</a>
                                                            @endcan

                                                            @can('Delete Roles')
                                                                <a class="btn btn-danger btn-sm" href="{{Route('destroy.roles', $role->id)}}"
                                                                    id="delete">Delete</a>
                                                            @endcan
                                                        </td>
                                                    @endcanany
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