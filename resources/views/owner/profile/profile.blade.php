@extends('layouts.app')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mt-4 mb-4">
            <h1 class="h1 mb-0 text-gray-800">Profile</h1>
            {{-- <h1>User Profile</h1> --}}

        </div>

        <div class="row mt-4 justify-content-center">
            <div class="col-4">
                <div class="card shadow mb-4">
                    {{-- <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Of Owner Restaurant</h6>
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addnew">
                <i class="bi bi-clipboard2-plus-fill"></i> Add New Food
              </button>
        </div> --}}
                    <div class="card-body text-center">
                            <div class="align-middle">
                                <img src="{{ $user->image_url }}" alt="User Image">

                            </div>
                            <p class="mt-4"><strong>Full Name: </strong>{{ $user->first_name }} {{ $user->last_name }}</p>
                            <p><strong>Email: </strong>{{ $user->email }}</p>
                            <p><strong>Phone: </strong>{{ $user->phone }}</p>
                      
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
