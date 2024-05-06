@extends('layouts.app')

@section('content')
    <div class="big-banner">
        <div class="content">

            <!-- Main content -->
            <section class="content ">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <!-- left column -->
                        <div class="col-md-8">
                            <div class="card-header">
                            <h3>Update Restaurant</h3>
                            </div>
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="card-body">
                                        <h4 class="text-primary">Information User</h4>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('first_name', $user->first_name) }}"
                                                        name="first_name">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input type="text" class="form-control" name="last_name"
                                                        value="{{ old('last_name', $user->last_name) }}"
                                                        placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{ old('email', $user->email) }}"
                                                        placeholder="Email">
                                                    <div style="color: red">{{ $errors->first('email') }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Password">
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <h4 class="text-primary">Information Restaurant</h4>


                                    {{-- <div class="card-body"> --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Restaurant Name</label>
                                                    <input type="text" class="form-control" name="name" 
                                                        value="{{ old('name', $restaurant->name) }}"
                                                        placeholder="Enter name">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input type="number" class="form-control" 
                                                        name="phone" value="{{ old('phone', $restaurant->phone) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" name="address" rows="5">{{ old('address', $restaurant->address) }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>

                                    {{-- </div> --}}
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection
