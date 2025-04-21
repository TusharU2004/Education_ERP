@extends('admin.admin_master')
@section('admin')

<style>
.permission-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    padding: 15px;
    border-radius: 8px;
}

.permission-item {
    align-items: center;
    padding: 8px;
    border-radius: 5px;
    transition: 0.3s;
}

.permission-item:hover {
    background: #7a15f7;
}

.permission-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #1abc9c;
}

.permission-item label {
    font-size: 15px;
    color: #ffffff;
    margin-left: 8px;
    cursor: pointer;
}
</style>

<div class="content-wrapper">
    <div class="container-full">         

        <section class="content">
            <div class="row">
                <div class="col-12">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create Roles</h3>
                        </div>

                        <div class="box-body">
                            <form action="{{ route('store.roles') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <h4>Name</h4>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Role Name" value="{{ old('name') }}">
                                </div>

                                <h4>Select Permissions</h4>
                                <div class="permission-container">
                                    @if ($permissions->isNotEmpty())
                                        @foreach ($permissions as $permission)
                                            <div class="permission-item">
                                                <input type="checkbox" id="permission-{{$permission->id}}" name="permission[]" value="{{$permission->name}}">
                                                <label for="permission-{{$permission->id}}">{{$permission->name}}</label>   
                                            </div>                  
                                        @endforeach
                                    @endif
                                </div>

                                <div class="mt-3">
                                    <input type="submit" value="Submit" class="btn btn-rounded btn-info">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

@endsection
