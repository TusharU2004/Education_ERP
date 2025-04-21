@extends('admin.admin_master')
@section('admin')


   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">

            <div class="box">
               <div class="box-header with-border">
                  <h4 class="box-title">Add Student Class</h4>
               </div>

               <div class="box-body">

                  <form method="post" action="{{ route('store.student.class') }}">
                     @csrf
                     <div class="col-12">
                        <div class="form-group">
                           <h5>Student Class Name <span class="text-danger">*</span></h5>
                           <div class="controls">
                              <input type="text" name="name" class="form-control">
                              @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                           </div>

                        </div>
                        <div class="text-xs-right">
                           <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
                        </div>
                  </form>
               </div>
            </div>

         </section>

      </div>
   </div>

@endsection