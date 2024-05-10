@extends('layouts.app')

@section('content')
    <div class="big-banner">
        <div class="container-fluid">
            <!-- Page Heading -->
            {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
            <h1 class="h3 mb-0 text-gray-800">User Order Details</h1>
        </div> --}}

            @include('_massage')

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                    <h3 class="m-0 font-weight-bold text-primary">DataTables Order Detail</h3>
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back to User Orders</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        {{-- display top --}}
                        <div class="row mb-4">
                            <div class="col-4">
                                <p><strong>User: </strong> {{ $getCustomerOrder->customer->name }}</p>
                                <p><strong>Phone: </strong> {{ $getCustomerOrder->phone }}</p>
                            </div>
                            <div class="col-4">
                                <p><strong>Payment Method:</strong> {{ $getCustomerOrder->payment->payment_method }}</p>
                                <p><strong>Total Quantity:</strong> {{ $getCustomerOrder->orderItems->sum('quantity') }}</p>
                            </div>
                            <div class="col-4">
                                <p><strong>Order Date:</strong> {{ $getCustomerOrder->created_at }}</p>
                                <p><strong>Order Number:</strong> {{ $getCustomerOrder->ordernumber }}</p>
                            </div>
                        </div>
                        {{-- table display food order --}}
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Food Name</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>SubTotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalSubtotal = 0;
                                @endphp
                                @foreach ($getCustomerOrder->orderItems as $item)
                                    @php
                                        $subTotal = $item->quantity * $item->food->price;
                                        $totalSubtotal += $subTotal;
                                    @endphp
                                    <tr class="text-center">
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle"><img class="rounded-circle" height="75" width="75"
                                                src="{{ $item->food->image_url }}" alt=""></td>
                                        <td class="align-middle">{{ $item->food->name }}</td>
                                        <td class="align-middle">{{ $item->food->type }}</td>
                                        <td class="align-middle">{{ $item->quantity }}</td>
                                        <td class="align-middle">${{ number_format($item->food->price, 2) }}</td>
                                        <td class="align-middle">${{ number_format($subTotal, 2) }}</td>
                                    </tr>
                                @endforeach
                                {{-- <tr class="text-center">
                                    <th colspan="4"></th>
                                    <th class="text-danger text-end"></th>
                                    <th class="align-middle text-danger">
                                        
                                    </th>
                                </tr>
                                <tr class="text-center">
                                    <th colspan="4"></th>
                                    <th class="text-danger text-end"></th>
                                    <th class="align-middle text-danger">
                                        
                                    </th>
                                </tr>
                                
                                <tr class="text-center">
                                    <th colspan="4"></th>
                                    <th class="align-middle text-end"></th>
                                    <th>
                                        
                                    </th>
                                </tr> --}}
                            </tbody>
                        </table>

                        {{-- End Table --}}
                    </div>
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-6 text-end">
                                    <h4>Total:</h4>
                                    <h4>Payment:</h4>
                                    <h4>Print:</h4>

                                </div>
                                {{-- @php
                                    dd($customerOrderFood);
                                @endphp --}}

                                @php
                                    $amount = $getCustomerOrder->payment->amount;
                                    $currency = $getCustomerOrder->payment->currency;
                                    $usd = 0;
                                    $khr = 0;

                                    if ($currency === 'USD') {
                                        $usd = $amount;
                                    } elseif ($currency === 'KHR') {
                                        $khr = $amount;
                                    }
                                @endphp

                                <div class="col-6">
                                    <h4>$ {{ number_format($totalSubtotal, 2) }}</h4>
                                    <h4>
                                        {{ $amount }}{{ $currency === 'USD' ? '$ ' : ' ៛' }}
                                    </h4>
                                    <a class="btn btn-md btn-outline-success"
                                        href="{{ route('pos-printRecipe', ['orderId' => $getCustomerOrder->id]) }}">
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
