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
                                <th>User Name</th>
                                <th>Food Name</th>
                                <th>Quantity</th>
                                <th>Table No</th>
                                <th>Remark</th>
                                <th>Payment</th>
                                <th>Created At</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($foodOrders as $foodOrder)
                                <tr>
                                    <td>{{ $foodOrder->id }}</td>
                                    <td>{{ $foodOrder->first_name }}{{ $foodOrder->last_name }}</td>
                                    <td>{{ $foodOrder->food->name }}</td>
                                    <td>{{ $foodOrder->order->quantity }}</td>
                                    <td>{{ $foodOrder->order->table_no }}</td>
                                    <td>{{ $foodOrder->order->remark }}</td>
                                    <td>Pay Online</td>
                                    <td>{{ $foodOrder->order->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $foodOrders->links() }} <!-- Pagination links -->
                </div>
            </div>
        </div>

    </div>
@endsection
