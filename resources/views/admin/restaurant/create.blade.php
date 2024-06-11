@extends('layouts.app')

@section('content')
    <div class="big-banner">
        <div class="content">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <!-- left column -->
                        <div class="col-md-8">
                            <div class="card-header">
                                <h3>Add Restaurant</h3>
                            </div>
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <!-- form start -->
                                <form method="post" action="{{ URL::to('admin/restaurant/store') }}" enctype="multipart/form-data">
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
                                                    <input type="text" class="form-control" name="first_name" required placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Last Name <span style="color: red">*</span></label>
                                                    <input type="text" class="form-control" name="last_name" required placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Email <span style="color: red">*</span></label>
                                                    <input type="email" class="form-control" name="email" required placeholder="Email">
                                                    <div style="color: red">{{ $errors->first('email') }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Password <span style="color: red">*</span></label>
                                                    <input type="password" class="form-control" name="password" required placeholder="Password">
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
                                                    <input type="text" class="form-control" name="name" required placeholder="Enter name">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Phone Number <span style="color: red">*</span></label>
                                                    <input type="number" class="form-control" value="{{ old('phone') }}" name="phone" required placeholder="Phone Number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mapform">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Latitude <span style="color: red">*</span></label>
                                                        <input type="text" class="form-control" name="latitude" id="lat" required>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Longitude <span style="color: red">*</span></label>
                                                        <input type="text" class="form-control" name="longitude" id="lng" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group" id="map" style="height: 400px;" class="my-3"></div>

                                        <div class="form-group">
                                            <label>Address <span style="color: red">*</span></label>
                                            <textarea class="form-control" name="address" id="address" rows="3" required placeholder="Enter Address..."></textarea>
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

@push('scripts')
<script>
    let map;
    let marker;
    let geocoder;

    function initMap() {
        const defaultPosition = { lat: -34.397, lng: 150.644 };

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultPosition,
            zoom: 8,
            scrollwheel: true
        });

        marker = new google.maps.Marker({
            position: defaultPosition,
            map: map,
            draggable: true
        });

        geocoder = new google.maps.Geocoder();

        google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng);
        });

        marker.addListener('dragend', function(event) {
            placeMarker(event.latLng);
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
                placeMarker(pos);
            });
        }
    }

    function placeMarker(location) {
        marker.setPosition(location);
        document.getElementById('lat').value = location.lat();
        document.getElementById('lng').value = location.lng();
        getAddress(location);
    }

    function getAddress(location) {
        geocoder.geocode({'location': location}, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    document.getElementById('address').value = results[0].formatted_address;
                } else {
                    document.getElementById('address').value = 'No results found';
                }
            } else {
                document.getElementById('address').value = 'Geocoder failed due to: ' + status;
            }
        });
    }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAX7F8MsZDGZzfmu2Jvg9LwuI7ftHJ1ASU&callback=initMap"
    type="text/javascript"></script>
@endpush
