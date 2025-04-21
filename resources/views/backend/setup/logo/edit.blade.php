@extends('admin.admin_master')
@section('admin')

    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="box bb-3 border-warning">
                    <div class="box-header with-border">

                        <form method="post" action="{{ route('school.logo.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label class="form-label">OLD LOGO</label>
                                        <img id="showImage" src="{{ asset('upload/school_logo.png') }}"
                                            style="width: 100px; width: 100px; border: 1px solid #000000;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label class="form-label">NEW LOGO</label>
                                        <input type="file" name="image" accept=".png,.wepb,.jpg,.jpeg">
                                    </div>
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