@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">Profile</h1>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <div class="image-container">
                                    <img src="{{ $user->image_url }}" class="img-fluid rounded profile-image" alt="User Image">
                                </div>
                            </div>
                            <h2 class="h5 text-center mb-4">{{ $user->first_name }} {{ $user->last_name }}</h2>
                            <p class="text-muted text-center mb-4">{{ $user->email }}</p>
                            <p class="text-muted text-center mb-4">{{ $user->phone }}</p>
                            <div class="text-center">
                                <a href="{{ url('/owner/profile/edit') }}" class="btn btn-secondary btn-sm">Edit Profile</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <div class="image-container">
                                    <img src="{{ Auth::user()->restaurant->image }}" class="img-fluid rounded profile-image" alt="Restaurant Image">
                                </div>
                            </div>
                            <h2 class="h5 text-center mb-4">{{ Auth::user()->restaurant->name }}</h2>
                            <p class="text-muted text-center mb-4">{{ Auth::user()->restaurant->address }}</p>
                            <div class="text-center">
                                <a href="{{ url('/restaurant/profile/edit') }}" class="btn btn-secondary btn-sm">Edit Restaurant Info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="file" id="imageInput" style="display: none;" accept="image/*">

<script>
    document.querySelector('label[for="imageInput"]').addEventListener('click', function() {
        document.getElementById('imageInput').click();
    });

    document.getElementById('imageInput').addEventListener('change', function() {
        // You can add logic here to handle the file change, e.g., trigger form submission
        // For example, this.form.submit();
    });
</script>
<style>
    .image-container {
        width: 200px; /* Adjust as needed */
        height: 200px; /* Adjust as needed */
        overflow: hidden;
        margin: 0 auto; /* Center the container */
    }
    .image-container img {
        width: 100%;
        height: auto;
    }
</style>
@endsection
