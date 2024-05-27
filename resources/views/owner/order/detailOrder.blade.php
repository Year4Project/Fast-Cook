@extends('layouts.app')

@section('content')
    <div class="big-banner">
        <div class="container-fluid">
            @include('_massage')

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                    <h3 class="m-0 font-weight-bold text-primary">DataTables Order Detail</h3>
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back to User Orders</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-4">
                            <div class="col-4">
                                <p><strong>User:</strong> {{ $getOrderDetails->user->first_name }}
                                    {{ $getOrderDetails->user->last_name }}</p>
                                <p><strong>Table No:</strong> {{ $getOrderDetails->table_no }}</p>
                            </div>
                            <div class="col-4">
                                <p><strong>Remark:</strong> {{ $getOrderDetails->remark }}</p>
                                <p><strong>Total Quantity:</strong> {{ $getOrderDetails->total_quantity }}</p>
                            </div>
                            <div class="col-4">
                                <p><strong>Order Date:</strong> {{ $getOrderDetails->created_at }}</p>
                                <p><strong>Order Number:</strong> {{ $getOrderDetails->ordernumber }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Food ID</th>
                                            <th>Food Name</th>
                                            <th>Type of Food</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalCost = 0;
                                            $currency = null;
                                        @endphp
                                        @foreach ($getOrderDetails->foods as $food)
                                            @php
                                                $subtotal = $food->pivot->quantity * $food->price;
                                                $totalCost += $subtotal;
                                                $currency = $food->currency;
                                            @endphp
                                            <tr class="text-center">
                                                <td class="align-middle">{{ $loop->iteration }}</td>
                                                <td class="align-middle"><img class="rounded-circle" height="75" width="75" src="{{ $food->image_url }}" alt=""></td>
                                                <td class="align-middle">{{ $food->code }}</td>
                                                <td class="align-middle">{{ $food->name }}</td>
                                                <td class="align-middle">{{ $food->type }}</td>
                                                <td class="align-middle">{{ $food->pivot->quantity }}</td>
                                                <td class="align-middle">
                                                    @if ($food->currency === 'KHR')
                                                        {{ number_format($food->price, 2) }} ៛
                                                    @else
                                                        {{ number_format($food->price, 2) }} $
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @if ($food->currency === 'KHR')
                                                        {{ number_format($subtotal, 2) }} ៛
                                                    @else
                                                        {{ number_format($subtotal, 2) }} $
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4"></div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-6 text-end">
                                        <h4>Total:</h4>
                                        <h4>Payment:</h4>
                                        <h4>Print:</h4>
                                    </div>
                                    <div class="col-6">
                                        <h4>
                                            @if ($currency === 'KHR')
                                                {{ number_format($totalCost, 2) }} ៛
                                            @else
                                                {{ number_format($totalCost, 2) }} $
                                            @endif
                                        </h4>
                                        <h4>Cash</h4>
                                        <a class="btn btn-outline-success" href="{{ route('api-printRecipe', ['orderId' => $getOrderDetails->id]) }}">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
