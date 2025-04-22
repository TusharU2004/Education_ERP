
@extends('admin.admin_master')
@section('admin')
  
   <div class="content-wrapper">
      <div class="container-full">

         <section class="content">

            <div class="box">
               <div class="box-header with-border">
                  <h4 class="box-title">Add Student</h4>
               </div>

               <div class="box-body">
                  <div class="row">
                     <div class="col">
                        <form method="post" action="{{ route('store.student.registration') }}" enctype="multipart/form-data">
                           @csrf
                           <div class="row">

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Student Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter Student Name">
                                       @error('name')<span class=text-danger>{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Father's Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname') }}" placeholder="Enter Student Father Name">
                                       @error('fname')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Last Name <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ old('lname') }}" placeholder="Enter Student Last Name">
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
                                       <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" placeholder="Enter Parent Mobile Number"
                                       oninput="this.value = this.value.replace(/[^0-9]/g,'')" maxlength="10">
                                       @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>
                        
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Address <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="Enter Student Address">
                                       @error('address')<span class="text-danger">{{ $message }}</span>@enderror
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
                                       @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                           </div>

                           <div class="row">

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Religion</h5>
                                    <div class="controls">
                                    <select name="religion" class="form-control @error('religion') is-invalid @enderror">
                                       <option value="" selected="" disabled="">Select Religion</option>
                                       <option value="Islam">Islam</option>
                                       <option value="Hindu">Hindu</option>
                                       <option value="Christan">Christan</option>
                                    </select>
                                       @error('religion')<span class="text-danger">{{ $message }}</span>@enderror
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
                                    <h5>Discount <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <input type="text" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount') }}" placeholder="Enter Student Discount">
                                       @error('discount')<span class=text-danger>{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                           </div>
                           
                           <div class="row">

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Year <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="year_id" class="form-control @error('year_id') is-invalid @enderror">
                                          <option value="" selected="" disabled="">Select Year</option>
                                          @foreach($years as $year)
                                             <option value="{{ $year->id }}">{{ $year->name }}</option>
                                          @endforeach
                                       </select>
                                       @error('year_id')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Class <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="class_id" class="form-control @error('class_id') is-invalid @enderror">
                                          <option value="" selected="" disabled="">Select Class</option>
                                          @foreach($classes as $class)
                                             <option value="{{ $class->id }}">{{ $class->name }}</option>
                                          @endforeach
                                       </select>
                                       @error('class_id')<span class=text-danger>{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Group</h5>
                                    <div class="controls">
                                       <select name="group_id" class="form-control @error('group_id') is-invalid @enderror">
                                          <option value="" selected="" disabled="">Select Group</option>
                                          @foreach($groups as $group)
                                             <option value="{{ $group->id }}">{{ $group->name }}</option>
                                          @endforeach
                                       </select>
                                       @error('group_id')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                           </div>

                           <div class="row">
                              
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Shift <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                       <select name="shift_id" class="form-control @error('shift_id') is-invalid @enderror">
                                          <option value="" selected="" disabled="">Select Shift</option>
                                          @foreach($shifts as $shift)
                                             <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                          @endforeach
                                       </select>
                                       @error('shift_id')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
                                 <div class="form-group">
                                    <h5>Profile Image</h5>
                                    <div class="controls">
                                       <input type="file" name="image" class="form-control" id="image">
                                       @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-4">
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