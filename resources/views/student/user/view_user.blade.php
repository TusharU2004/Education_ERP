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
                        <a href="{{ route('users.create') }}" style="float: right;" class="btn btn-rounded btn-success mb-5">
                           Add User
                        </a>
                     </div>

                     <div class="box-body">
                        <div class="table-responsive">
                           <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                 <tr>
                                    <th width="5%">SL</th>
                                    <th>designation</th>
                                    <th>Role</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Code</th>
                                    <th width="25%">Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($users as $user)
                                    <tr>
                                       <td>{{$loop->iteration}}</td>
                                       <td>{{ optional($user->designation)->name  }}</td>
                                       <td>{{$user->roles->pluck('name')->implode(',')}}</td>
                                       <td>{{ $user->name }}</td>
                                       <td>{{ $user->email }}</td>
                                       <td>{{ $user->code }}</td>
                                       <td>
                                          <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info">Edit</a>
                                          <a href="{{ route('destroy.users', $user->id) }}" class="btn btn-danger" id="delete">Delete</a>
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