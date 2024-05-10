@extends('layouts.app')

@section('content')
<div class="big-banner">
    <div class="container-fluid">




        @include('_massage')

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Customer Orders From App</h3>
            </div>
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
                                <td>Order Number	</td>
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
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $foodOrder->user->first_name }} {{ $foodOrder->user->last_name }}</td>
                                        <td class="align-middle">{{ $foodOrder->ordernumber }}</td>
                                        <td class="align-middle">{{ $foodOrder->table_no }}</td>
                                        <td class="align-middle">{{ $foodOrder->remark }}</td>
                                        <td class="align-middle">{{ $foodOrder->total_quantity }}</td>
                                        <td class="align-middle">Pay Online</td>
                                        <td class="align-middle">{{ $foodOrder->created_at }}</td>
                                        <td class="align-middle">
                                            <a href="{{ route('owner.order.details', ['orderId' => $foodOrder->id]) }}"
                                                class="btn btn-md btn-circle btn-outline-primary">
                                                <i class="fas fa-list"></i>
                                            </a>

                                            <a class="btn btn-outline-success"
                                                href="{{ route('api-printRecipe', ['orderId' => $foodOrder->id]) }}">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                        {{-- <td class="align-middle">{{ $foodOrder->total_price }}</td> --}}
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="row custom-center">
                        {{ $getOrderUser->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
