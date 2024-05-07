@extends('layouts.app')

@section('content')
    <div class="big-banner">
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
                        <form action="{{ route('admin.user.update', ['userId' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
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

                                <h4 class="text-primary">Information User</h4>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('first_name', $user->first_name) }}" name="first_name">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" name="last_name"
                                                value="{{ old('last_name', $user->last_name) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email', $user->email) }}">
                                            <div style="color: red">{{ $errors->first('email') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password">
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
                                                value="{{ old('name', $restaurant->name) }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="number" class="form-control" name="phone"
                                                value="{{ old('phone', $user->phone) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mapform">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Latitude</label>
                                                <input type="text" class="form-control" name="lat"
                                                id="lat">
                                            </div>
                                           
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Longitude</label>
                                                <input type="text" class="form-control" name="lng"
                                                id="lng">
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                {{-- <div id="map" style="height: 400px; width: 800px;" class="my-3"></div> --}}

                                <div class="form-group" id="map" style="height: 400px; width: 800px;" class="my-3"></div>


                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address" rows="5">{{ old('address', $restaurant->address) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Old Image Food</label>
                                    <div class="container ms-2 mt-2 ">
                                        <img height="150" width="150" src="{{ $restaurant->image }}"
                                            alt="Old Image">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Image Food</label>
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
        </div>
    </div>
@endsection

<script>
    let map;

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: -34.397,
                lng: 150.644
            },
            zoom: 8,
            scrollwheel: true
        });
    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABHeEAH3j-ethqsdzeULdSGk80xVm7Two&callback=initMap"
    type="text/javascript"></script>
