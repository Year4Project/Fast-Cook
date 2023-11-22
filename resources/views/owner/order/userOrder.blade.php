@extends("layouts.app")

@section("content")

<div class="container-fluid">
    

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color: black">
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Quantity</th>
                            <th>Table Note</th>
                            <th>Remak</th>
                            <th>Payment Mode</th>
                            <th>Ordered Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getRecord as $orders)
                        <tr>
                            <td>{{ $orders->id }}</td>
                            <td>{{ $orders->first_name }} {{ $orders->last_name }}</td>
                            <td>{{ $orders->quantity }}</td>
                            <td>{{ $orders->table_no }}</td>
                            <td>{{ $orders->remark }}</td>
                            <td></td>
                            <td>{{ date('d-m-Y | h:i A', strtotime($orders->created_at)) }}</td>
                            <td>
                                <a class="nav-link" href="{{ url('owner/order/listFoodUser/'.$orders->id) }}">
                                    <i class="fas fa-list">  List Order</i>
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