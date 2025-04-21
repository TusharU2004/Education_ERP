@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">


            <div class="box">
               <div class="box-header with-border">
                  <h4 class="box-title">Edit User Details</h4>
               </div>

               <div class="box-body">
                  <form action="{{ route('update.users', $user->id) }}" method="post">
                     @csrf
                     <input type="hidden" name="_method" value="put">
                     
                     <div class="row">
                        
                        <div class="col-md-6">
                           <div class="form-group">
                              <h5>Name <span class="text-danger">*</span></h5>
                              <div class="controls">
                                 <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                 @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group">
                              <h5>E-mail <span class="text-danger">*</span></h5>
                              <div class="controls">
                                 <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                                 @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="form-group mt-3">
                        <h5>Assign Roles</h5>
                        <div class="row">
                           @if ($roles->isNotEmpty())
                              @foreach ($roles as $role)
                                 <div class="col-md-3 mt-2">
                                    <div class="form-check">
                                       <input type="checkbox" class="form-check-input" id="role-{{$role->id}}" name="role[]"
                                          value="{{$role->name}}" {{ $hasRoles->contains($role->id) ? 'checked' : '' }}>
                                       <label class="form-check-label" for="role-{{$role->id}}">
                                          {{$role->name}}
                                       </label>
                                    </div>
                                 </div>
                              @endforeach
                           @endif
                        </div>
                     </div>

                     <br>

                     <div class="form-group text-center">
                        <input type="submit" class="btn btn-rounded btn-info mb-5" value="Update">
                     </div>

                  </form>
               </div>
            </div>
         </section>
      </div>
   </div>

@endsection