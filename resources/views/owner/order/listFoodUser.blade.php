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
                            <th>Food Name</th>
                            <th>Code Food</th>
                            <th>Quantity</th>
                            <th>Table Note</th>
                            <th>Remak</th>
                            <th>Image</th>
                            <th>Original Price</th>
                            <th>Discound Price</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getOrderUser as $orderItem)
                            <tr>
                                <td>{{ $orderItem->user_id }}</td>
                                <td>{{ $orderItem->first_name }} {{ $orderItem->last_name }}</td>
                                <td>{{ $orderItem->name }}</td>
                                <td>{{ $orderItem->code }}</td>
                                <td>{{ $orderItem->quantity }}</td>
                                <td>{{ $orderItem->table_no }}</td>
                                <td>{{ $orderItem->remark }}</td>
                                <td><img height="75" width="75" src="/upload/food/{{$orderItem->image}}" alt=""></td>
                                <td>{{ $orderItem->oPrice}}$</td>
                                <td>{{ $orderItem->dPrice}}$</td>
                                <td>{{ ($orderItem->oPrice * $orderItem->quantity) - ($orderItem->dPrice * $orderItem->quantity) }}$</td>
                                <td>
                                    <a class="nav-link" href="{{ url('owner/order/edit/'.$orderItem->id) }}">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>

                                    <a class="nav-link" href="{{ url('owner/order/delete/'.$orderItem->id) }}">
                                        <i class="fas fa-fw fa-trash-alt icon-trash-red"></i>
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