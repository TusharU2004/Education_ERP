@extends('admin.admin_master')
@section('admin')

   <div class="content-wrapper">
      <div class="container-full">
        
         <section class="content">
            <div class="row">
               <div class="col-12">

                  <div class="box">
                     <div class="box-header with-border">
                        <h3 class="box-title">Other Cost List </h3>
                        <a href="{{ route('other.cost.add') }}" style="float: right;" class="btn btn-rounded btn-success mb-5"> Add Other Cost</a>
                     </div>
                    
                     <div class="box-body">
                        <div class="table-responsive">
                           <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                 <tr>
                                    <th width="5%">SL</th>
                                    <th>Date</th>
                                    <th>Amount </th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($allData as $key => $value)
                                 <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ date('d-m-Y', strtotime($value->date)) }}</td>
                                    <td> {{ $value->amount }}</td>
                                    <td> {{ $value->description }}</td>
                                    <td>
                                       <img src="{{ !empty($value->image) ? url('upload/cost_images/' . $value->image) : url('upload/no_image.jpg') }}" 
                                       style="width: 70px; height: 50px; cursor: pointer;" onclick="showImage(this.src)">
                                    </td>
                                    <td>
                                       <a href="{{ route('other.cost.edit', $value->id) }}" class="btn btn-info">
                                          Edit
                                       </a>
                                       <a id="delete" href="{{ route('other.cost.delete',$value->id) }}" class="btn btn-danger">
                                          Delete
                                       </a>
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
   
   <script>
      function showImage(src) {
         let modal = document.createElement("div");
         modal.innerHTML = `<div style="position:fixed; inset:0;  display:flex; justify-content:center; align-items:center;" onclick="this.remove() ">
                              <img src="${src}" style="max-width:90%; max-height:90%;"></div>`;
         document.body.appendChild(modal.firstChild);
      }
   </script>

@endsection