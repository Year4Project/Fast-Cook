@extends('layouts.app')

@section('content')
    <div class="big-banner">
        <div class="container-fluid">

            @include('_massage')

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                    <h3 class="m-0 font-weight-bold text-primary">POS Order</h3>
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back to User Orders</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        {{-- display top --}}
                        <div class="row">
                            {{-- <div class="col-md-2">
                            <p><strong>User:</strong> {{ $getOrderDetails->user->first_name }}
                                {{ $getOrderDetails->user->last_name }}</p>
                            <p><strong>Table No:</strong> {{ $getOrderDetails->table_no }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Remark:</strong> {{ $getOrderDetails->remark }}</p>
                            <p><strong>Total Quantity:</strong> {{ $getOrderDetails->total_quantity }}</p>
                        </div> --}}
                        </div>
                        {{-- table display food order --}}
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Order Number</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    // Calculate the correct starting number based on the current page
                                    $perPage = $orderCustomer->perPage();
                                    $currentPage = $orderCustomer->currentPage();
                                    $startNumber = ($currentPage - 1) * $perPage + 1;
                                @endphp
                                @foreach ($orderCustomer as $index => $orderItem)
                                    <tr class="text-center">
                                        <td class="align-middle">{{ $startNumber + $index }}</td>
                                        <td class="align-middle">{{ $orderItem->ordernumber }}</td>
                                        <td class="align-middle">{{ $orderItem->created_at }}</td>
                                        <td class="align-middle">
                                            <a href="{{ route('POS-CustomerOrder.detail', ['orderId' => $orderItem->id]) }}"
                                                class="btn btn-md btn-circle btn-outline-primary">
                                                <i class="fas fa-list"></i>
                                            </a>
                                            <a class="btn btn-md btn-outline-success"
                                                href="{{ route('pos-printRecipe', ['orderId' => $orderItem->id]) }}">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="row custom-center">
                            {{ $orderCustomer->links() }}
                        </div>
                        {{-- End Table --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
