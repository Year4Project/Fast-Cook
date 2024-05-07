@extends('layouts.app')

@section('content')
    <div class="big-banner">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- left column -->
                <div class="col-md-8">
                    <div class="card-header">
                        <h3>Update Admin</h3>
                    </div>
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" action="{{ route('admin.update', $getRecord->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                 <!-- Error Alert -->
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ old('first_name', $getRecord->first_name) }}">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('last_name', $getRecord->last_name) }}" name="last_name"
                                        >
                                </div>
                                <div class="form-group">
                                    <label>Old Image Food</label>
                                    <div class="container ms-2 mt-2 ">
                                        <img height="150" width="150" src="{{ $getRecord->image_url }}"
                                            alt="Old Image">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Image Food</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', $getRecord->email) }}">
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="number" class="form-control" value="{{ old('phone', $getRecord->phone) }}"
                                        name="phone">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password">
                                    <p>Leave blank if you don't want to change the password.</p>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
