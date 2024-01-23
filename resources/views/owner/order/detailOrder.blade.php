@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
            <h1 class="h3 mb-0 text-gray-800">User Order Details</h1>
        </div> --}}

        @include('_massage')

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Order Detail</h6>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back to User Orders</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Image</th>
                                <th>Food ID</th>
                                <th>Food Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>SubTotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>User:</strong> {{ $getOrderDetails->user->first_name }} {{ $getOrderDetails->user->last_name }}</p>
                                    <p><strong>Table No:</strong> {{ $getOrderDetails->table_no }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Remark:</strong> {{ $getOrderDetails->remark }}</p>
                                    <p><strong>Total Quantity:</strong> {{ $getOrderDetails->total_quantity }}</p>
                                </div>
                                <div class="col-8"></div>
                            </div>


                @foreach ($getOrderDetails->foods as $food)
                <tr class="text-center">
                    <th class="align-middle">{{ $food->id }}</th>
                    <td class="align-middle"><img class="rounded-circle" height="75" width="75"
                        src="{{ $food->image_url }}" alt=""></td>
                    <th class="align-middle">{{ $food->code }}</th>
                    <th class="align-middle">{{ $food->name }}</th>
                    <th class="align-middle">{{ $food->pivot->quantity }}</th>
                    <th class="align-middle">{{ $food->price }}</th>
                    <th class="align-middle"></th>
                </tr>
            @endforeach
            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
