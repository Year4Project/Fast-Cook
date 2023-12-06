@extends("layouts.app")

@section("content")

<div class="container-fluid">


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mt-4">
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
                <table class="table table-bordered table mx-auto text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color: black;">
                            <th>#</th>
                            <th>Customer ID</th>
                            <th>Food Name</th>
                            <th>Code Food</th>
                            <th>Quantity</th>
                            <th>Table Note</th>
                            <th>Image</th>
                            <th>Total Price</th>
                            <th>Paid Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getOrderUser as $orderItem)
                            <tr>
                                <td>{{ $orderItem->id }}</td>
                                <td>{{ $orderItem->user_id }}</td>
                                <td>{{ $orderItem->name }}</td>
                                <td>{{ $orderItem->code }}</td>
                                <td>{{ $orderItem->quantity }}</td>
                                <td>{{ $orderItem->table_no }}</td>
                                <td><img height="75" width="75" src="/upload/food/{{$orderItem->image}}" alt=""></td>
                                <td>{{ ($orderItem->oPrice * $orderItem->quantity) - ($orderItem->dPrice * $orderItem->quantity) }}$</td>
                                <td></td>
                                <td>
                                    <a class="btn btn-sm btn-circle btn-outline-success me-2" href="#">
                                        <i class="fas fa-fw fa-print"></i>
                                    </a>
                                    <a class="btn btn-sm btn-circle btn-outline-primary" href="{{ url('owner/order/edit/'.$orderItem->id) }}">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>

                                    <a class="btn btn-sm btn-circle btn-outline-danger ms-2" href="{{ url('owner/order/delete/'.$orderItem->id) }}">
                                        <i class="fas fa-fw fa-trash-alt"></i>
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
