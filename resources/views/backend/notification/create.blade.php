@extends('admin.admin_master')
@section('admin')

    <div class="content-wrapper">
        <div class="container-full">

            <section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Message</h4>
                    </div>

                    <div class="box-body">
                        <form method="post" action="{{ route('notification.send') }}">
                            @csrf
                            <div class="form-group">
                                <h5>Write Message Here<span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="message" class="form-control @error('message') custom-invalid @enderror">
                                    @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="text-xs-right">
                                <input type="submit" class="btn btn-rounded btn-info mb-5" value="Send notification">
                            </div>
                        </form>
                    </div>
                </div>

            </section>

        </div>
    </div>

@endsection