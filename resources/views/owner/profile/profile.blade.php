@extends('layouts.app')

@section('content')
<div class="big-banner">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mt-4 mb-4">
            <h1 class="h1 mb-0 text-gray-800">Profile</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row mt-4 justify-content-center">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <div class="profile-image-container">
                            @if ($user->image_url)
                                <label for="imageInput">
                                    <img src="{{ $user->image_url }}" class="img-fluid rounded-circle" height="150"
                                        width="150" alt="User Image" style="cursor: pointer;">
                                </label>
                            @else
                                <p class="no-image-text">No image available</p>
                            @endif
                        </div>
                        <p class="mt-4"><strong>{{ $user->first_name }} {{ $user->last_name }}</strong></p>
                        <p class="user-info"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="user-info"><strong>Phone:</strong> {{ $user->phone }}</p>

                        <a class="btn btn-secondary mt-3" href="{{ url('/owner/profile/edit') }}">Edit Profile</a>
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

    </div>
</div>
@endsection
