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
                            <th>Customer ID</th>
                            <th>Customer Name</th>
                            <th>Quantity</th>
                            <th>Table Note</th>
                            <th>Remak</th>
                            <th>More Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order as $orderItem)
                            <tr>
                                <td>{{ $orderItem->user_id }}</td>
                                <td>{{ $orderItem->first_name }} {{ $orderItem->last_name }}</td>
                                <td>{{ $orderItem->quantity }}</td>
                                <td>{{ $orderItem->table_note }}</td>
                                <td>{{ $orderItem->remark }}</td>
                                <td>
                                    <a class="nav-link" href="{{ url('owner/order/index/'.$orderItem->user_id) }}">
                                        <i class="fab fa-elementor"></i>
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