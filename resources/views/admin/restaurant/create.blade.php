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
                                <h3>Add Restaurant</h3>
                            </div>
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="{{ URL::to('admin/restaurant/store') }}"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}

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
                                                    <label>First Name <span style="color: red">*</span></label>
                                                    <input type="text" class="form-control" name="first_name" required
                                                        placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Last Name <span style="color: red">*</span></label>
                                                    <input type="text" class="form-control" name="last_name" required
                                                        placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Email <span style="color: red">*</span></label>
                                                    <input type="email" class="form-control" name="email" required
                                                        placeholder="Email">
                                                    <div style="color: red">{{ $errors->first('email') }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Password <span style="color: red">*</span></label>
                                                    <input type="password" class="form-control" name="password" required
                                                        placeholder="Password">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <h4 class="text-primary">Information Restaurant</h4>

                                    </div>


                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Restaurant Name</label>
                                                    <input type="text" class="form-control" name="name" required
                                                        placeholder="Enter name">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Phone Number <span style="color: red">*</span></label>
                                                    <input type="number" class="form-control" value="{{ old('phone') }}"
                                                        name="phone" required placeholder="Phone Number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mapform">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Latitude <span style="color: red">*</span></label>
                                                        <input type="text" class="form-control" name="latitude"
                                                        id="lat">
                                                    </div>
                                                   
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Longitude <span style="color: red">*</span></label>
                                                        <input type="text" class="form-control" name="longitude"
                                                        id="lng">
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>

                                <div class="form-group" id="map" style="height: 400px; width: 800px;" class="my-3"></div>


                                        {{-- <div id="map" style="height: 400px"></div>
                                    <button onclick="showMap(25.594095, 85.137566)">Show Map</button> --}}

                                        <div class="form-group">
                                            <label>Address <span style="color: red">*</span></label>
                                            <textarea class="form-control" name="address" rows="3" required placeholder="Enter Address..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control" name="image">
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
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection

<script>
    function showMap(lat, lng) {
        var mylatlng = {
            lat: lat,
            lng: lng
        };

        new google.maps.Marker({
            position: mylatlng,
            map: map,
        })
    }
</script>

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
