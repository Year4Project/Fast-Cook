@extends('layouts.app')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
            <h1 class="h3 mb-0 text-gray-800">Customer Orders</h1>
            {{-- <a href="{{ url('owner/food/create') }}" 
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add Menu</a> --}}
        </div>

        @include('_massage')

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Of Order</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-align-center">
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Restaurant ID</th>
                                <th>Items</th>
                                <th>Quantity</th>
                                <th>Table No</th>
                                <th>Remark</th>
                                <th>Payment</th>
                                <th>Created At</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getUserOrder as $food)
                                <tr>
                                    <td>{{ $food->id }}</td>
                                    <td>{{ $food->user_id }}</td>
                                    <td>{{ $food->restaurant_id }}</td>
                                    
                                    <td>{{ $food->quantity }}</td>
                                    <td>{{ $food->table_no }}</td>
                                    <td>{{ $food->remark }}</td>
                                    <td></td>
                                    <td>{{ $food->created_at }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-circle btn-outline-success me-2" href="{{url('owner/food/listFoodUser')}}">
                                            <i class="far fa-list-alt">List Food Order</i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
