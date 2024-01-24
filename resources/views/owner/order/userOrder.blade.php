@extends('layouts.app')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Customer Orders</h1>
            {{-- <a href="{{ url('owner/food/create') }}"
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add Menu</a> --}}
        </div>

        @include('_massage')

        <div class="card shadow mb-4">
            {{-- <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Of Order</h6>
            </div> --}}
            <div id="app">
                <order-component></order-component>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Table No</th>
                                <th>Remark</th>
                                <th>Quantity</th>
                                <th>Payment</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($getOrderUser->isEmpty())
                                <tr>
                                    <td colspan="11">
                                        <div style="margin-top: 50px; text-align: center;">No records found.</div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($getOrderUser as $foodOrder)
                                    <tr class="text-center">
                                        <td class="align-middle">{{ $foodOrder->id }}</td>
                                        <td class="align-middle">{{ $foodOrder->user->first_name }} {{ $foodOrder->user->last_name }}</td>
                                        <td class="align-middle">{{ $foodOrder->table_no }}</td>
                                        <td class="align-middle">{{ $foodOrder->remark }}</td>
                                        <td class="align-middle">{{ $foodOrder->total_quantity }}</td>
                                        <td class="align-middle">Pay Online</td>
                                        <td class="align-middle">{{ $foodOrder->created_at }}</td>
                                        <td class="align-middle">
                                            <a href="{{ route('owner.order.details', ['orderId' => $foodOrder->id]) }}"
                                                class="btn btn-primary">
                                                <i class="fas fa-list"> View Details</i>
                                            </a>

                                            <a class="btn btn-success" href="{{ url('owner/order/print/') }}">
                                                <i class="fas fa-print">Print</i>
                                            </a>
                                        </td>
                                        {{-- <td class="align-middle">{{ $foodOrder->total_price }}</td> --}}
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{-- {{ $foodOrders->links() }} <!-- Pagination links --> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
