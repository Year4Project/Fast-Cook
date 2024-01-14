<!-- resources/views/profile/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container-fluid">


        <h1>Edit Profile</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row mt-4 justify-content-center">
            <div class="col-4">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('owner.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <img src="{{ $user->image_url }}" class="img-fluid" alt="User Image">
                            <div class="form-group mt-4">
                                <!-- New image upload section -->
                                <label for="image">Profile Image:</label>
                                <input type="file" name="image" accept="image/*">
                                <small class="text-muted">Leave empty to keep the current image.</small>
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

                            <button type="submit">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
