@extends('layouts.app')

@section('content')
<div class="big-banner">
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mt-4 mb-4">
            <h1 class="h1 mb-0 text-gray-800">Edit Profile</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-body">

                        <form method="POST" action="{{ route('owner.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="text-center mb-4">
                                <label for="imageInput">
                                    <img src="{{ Auth::user()->restaurant->image }}" class="img-fluid rounded-circle" alt="User Image"
                                        style="width: 150px; height: 150px; cursor: pointer;">
                                </label>
                                <input type="file" id="imageInput" class="form-control-file" name="image" accept="image/*"
                                    style="display: none;">
                                <small class="form-text text-muted">Click the image to change profile picture</small>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name:</label>
                                        <input type="text" class="form-control" name="first_name"
                                            value="{{ $user->first_name }}" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name:</label>
                                        <input type="text" class="form-control" name="last_name"
                                            value="{{ $user->last_name }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        // JavaScript to handle image click
        document.getElementById('imageInput').addEventListener('change', function () {
            // You can add logic here to trigger form submission or handle the file change
            // For example, this.form.submit();
        });
    </script>
@endsection
