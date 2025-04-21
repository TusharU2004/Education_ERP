@extends('admin.admin_master')
@section('admin')


    <div class="content-wrapper">
        <div class="container-full">

            <section class="content">
                <div class="row">

                    <div class="col-12">

                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Permission List</h3>
                                @can('Create Permissions')
                                    <a href="{{ route('permission.create') }}" style="float: right;"
                                        class="btn btn-rounded btn-success mb-5"> Create Permission</a>
                                @endcan
                            </div>

                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">SL</th>
                                                <th>Name</th>
                                                <th>created_at</th>
                                                @canany(['Edit Permissions', 'Delete Permissions'])
                                                    <th width="25%">Action</th>
                                                @endcanany
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($permissions as $permission)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td> {{ $permission->name }}</td>
                                                    <td>{{ Carbon\Carbon::parse($permission->created_at) }}</td>
                                                    @canany(['Edit Permissions', 'Delete Permissions'])
                                                        <td>
                                                            @can('Edit Permissions')
                                                                <a href="{{ route('permission.edit', $permission->id) }}"
                                                                    class="btn btn-info btn-sm">Edit</a>
                                                            @endcan

                                                            @can('Delete Pemrissions')
                                                                <a href="{{ route('destroy.permission', $permission->id) }}"
                                                                    class="btn btn-danger btn-sm" id="delete">Delete</a>
                                                            @endcan
                                                        </td>
                                                    @endcanany
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->


                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->

        </div>
    </div>





@endsection
