@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
            <h1 class="h3 mb-0 text-gray-800">User Order Details</h1>
        </div>

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
                            <p><strong>User:</strong> {{ $orderDetails->first_name }} {{ $orderDetails->last_name }}</p>
                            <p><strong>Order ID:</strong> {{ $orderDetails->id }}</p>
                            <p><strong>Table No:</strong> {{ $orderDetails->order->table_no }}</h2>
                            <p><strong>Remark:</strong> {{ $orderDetails->order->remark }}</h2>
                            <p><strong>Time Order:</strong> {{ $orderDetails->order->created_at }}</h6>
                            <p><strong>Total:</strong> {{ $orderDetails->order->created_at }}</h6>
                            @php
                                $itemNumber = 1;
                                $totalPrice = 0;
                            @endphp

                            @foreach ($orderDetails->order->items as $item)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $itemNumber++ }}</td>
                                    <td class="align-middle">
                                        <img class="rounded-circle" height="75" width="75"
                                            src="{{ $item['food']->image_url }}"
                                            alt="{{ $item['food']->image_url }}">
                                    </td>
                                    <td class="align-middle">{{ $item['food_id'] }}</td>
                                    <td class="align-middle">{{ $item['food']->name }}</td>
                                    <td class="align-middle">{{ $item['quantity'] }}</td>
                                    <td class="align-middle">{{ $item['food']->price }}</td>
                                    <td class="align-middle">{{ $subTotal = $item['quantity'] * $item['food']->price }}</td>
                                    @php
                                        $totalPrice += $subTotal;
                                    @endphp
                                </tr>
                            @endforeach

                            <tr class="text-center">
                                <td colspan="6" class="text-right"><strong>Total:</strong></td>
                                <td>{{ $totalPrice }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
