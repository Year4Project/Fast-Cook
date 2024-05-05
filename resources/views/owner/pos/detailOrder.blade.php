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
                        {{-- <div class="row">
                            <div class="col-md-2">
                            <p><strong>User:</strong> {{ $customerOrderFood->customerOrder->cus }}
                                {{ $getOrderDetails->user->last_name }}</p>
                            <p><strong>Table No:</strong> {{ $getOrderDetails->table_no }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Remark:</strong> {{ $getOrderDetails->remark }}</p>
                            <p><strong>Total Quantity:</strong> {{ $getOrderDetails->total_quantity }}</p>
                        </div>
                        </div> --}}
                        {{-- table display food order --}}
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="table-dark">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Food Name</th>
                                    <th>Quantity</th>
                                    <th>Payment Method</th>
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
                                        <td class="align-middle">{{ $item->quantity }}</td>
                                        <td class="align-middle"></td>
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
                        <div class="col-4 ps-8">
                            <div class="row">
                                <div class="col-6 text-end">
                                    <p>Total:</p>
                                    <p>Payment:</p>
                                    <p>Print:</p>

                                </div>
                                {{-- @php
                                    dd($customerOrderFood);
                                @endphp --}}

                                <div class="col-6">
                                    <p>${{ number_format($totalSubtotal, 2) }}</p>
                                    <p>
                                       ${{ $getCustomerOrder->payment->amount }}
                                    </p>
                                    <a class="btn btn-md btn-outline-success" href="{{ route('pos-printRecipe', ['orderId' => $getCustomerOrder->id]) }}">
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
