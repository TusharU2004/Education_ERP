@extends('admin.admin_master')
@section('admin')
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">

            <div class="box">
               <div class="box-header with-border">
                  <h4 class="box-title">Add Employee</h4>
               </div>

               <div class="box-body">
                  <div class="row">
                     <div class="col">

                        <form method="post" action="{{ route('store.employee.registration') }}" enctype="multipart/form-data">
                        @csrf

                           <div class="row">
                              
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Employee Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter Employee Name">
                                       @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Father's Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname') }}" placeholder="Enter Employee Father Name">
                                       @error('fname')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Last Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ old('lname') }}" placeholder="Enter Employee Last Name">
                                       @error('lname')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                           </div>

                           <div class="row">

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Mobile Number <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" placeholder="Enter Mobile Number">
                                       @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Address <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="Enter Employee Address">
                                       @error('address')<span class="text-danger">{{ $message }}</span>
                                       @enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Gender <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                          <option value="" selected="" disabled="">Select Gender</option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                       </select>
                                       @error('gender')<span class="text-danger">{{ $message }}</span>
                                       @enderror
                                    </div>
                                 </div>
                              </div>

                           </div>

                           <div class="row">

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Religion</h5>
                                    <div class="controls">
                                       <select name="religion" id="religion" class="form-control @error('religion') is-invalid @enderror">
                                          <option value="" selected="" disabled="">Select Religion</option>
                                          <option value="Islam">Islam</option>
                                          <option value="Hindu">Hindu</option>
                                          <option value="Christan">Christan</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Date of Birth <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}">
                                       @error('dob')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Designation <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="designation_id" class="form-control @error('designation_id') is-invalid @enderror">
                                          <option value="" selected="" disabled="">Select Designation</option>
                                          @foreach($designation as $desi)
                                             <option value="{{ $desi->id }}">{{ $desi->name }}</option>
                                          @endforeach
                                       </select>
                                       @error('designation_id')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                           </div>

                           <div class="row">
                            
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Salary <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary') }}" placeholder="Enter Employee Salary">
                                       @error('salary')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Joining Date <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="date" name="join_date" class="form-control @error('join_date') is-invalid @enderror" value="{{ old('join_date') }}">
                                       @error('join_date')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <h5>Profile Image</h5>
                                    <div class="controls">
                                       <input type="file" name="image" class="form-control" id="image" accept=".jpg,.jpeg,.png,.webp">
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <div class="controls">
                                       <img id="showImage" src="{{ url('upload/no_image.jpg') }}" style="width: 100px; width: 100px; border: 1px solid #000000;">
                                    </div>
                                 </div>
                              </div>
                          
                           </div>

                           <div class="text-xs-right">
                              <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>

   <script type="text/javascript">
      $(document).ready(function () {
        $('#image').change(function (e) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#showImage').attr('src', e.target.result);
          }
          reader.readAsDataURL(e.target.files['0']);
        });
      });
   </script>

@endsection