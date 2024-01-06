@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
            <h1 class="h3 mb-0 text-gray-800">User Order Details</h1>
            {{-- <a href="{{ url('owner/food/create') }}" 
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add Menu</a> --}}
        </div>

        @include('_massage')

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Order Detail</h6>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back to User Orders</a>
            </div>
            <div id="app">
                <order-component></order-component>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Food ID</th>
                                <th>Food Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>

                            </tr>
                        </thead>
                        <tbody>
                            <p><strong>User:</strong> {{ $orderDetails->first_name }} {{ $orderDetails->last_name }}</p>
                            <p><strong>Order ID:</strong> {{ $orderDetails->id }}</p>
                            <p><strong>Table No:</strong> {{ $orderDetails->order->table_no }}</h2>
                            <p><strong>Remark:</strong> {{ $orderDetails->order->remark }}</h2>
                            <p><strong>Time Order:</strong> {{ $orderDetails->order->created_at }}</h6>
                               
                                @php $itemNumber = 1; @endphp
                                @foreach ($orderDetails->order->items as $item)
                                <tr>
                                    <td>{{ $itemNumber++ }}</td>
                                    <td>
                                        <img class="rounded-circle" height="75" width="75"
                                            src="{{ asset('/upload/food/' . $item['food']->image) }}"
                                            alt="{{ $item['food']->name }}">
                                    </td>
                                    <td>{{ $item['food_id'] }}</td>
                                    <td>{{ $item['food']->name }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ $item['food']->price }}</td>
                                    <td>{{ $item['quantity'] * $item['food']->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
