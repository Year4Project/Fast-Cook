@extends('layouts.app')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
            <h1 class="h3 mb-0 text-gray-800">User Order Details</h1>
            {{-- <a href="{{ url('owner/food/create') }}" 
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add Menu</a> --}}
        </div>

        @include('_massage')

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Order Detail</h6>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back to User Orders</a>
            </div>
            <div id="app">
                <order-component></order-component>
            </div>
            {{-- <script>
                // Initialize Laravel Echo
                const echo = new Echo({
                    broadcaster: 'pusher',
                    key: '{{ env('PUSHER_APP_KEY') }}',
                    cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                    encrypted: true,
                });

                // Listen for the OrderCreated event
                echo.channel('orders')
                    .listen('OrderCreated', (event) => {
                        console.log('OrderCreated event received:', event);

                        // Update the content on the client side with the new order data
                        // For example, you can manipulate the DOM or use a frontend framework
                    });
            </script> --}}

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Food Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>

                            </tr>
                        </thead>
                        <tbody>

                            <h2>User Name: {{ $orderDetails->first_name }} {{ $orderDetails->last_name }}</h2>
                            <p>Order ID: {{ $orderDetails->id }}</p>
                            <h2>Table No: {{ $orderDetails->order->table_no }}</h2>
                            <h2>Remark: {{ $orderDetails->order->remark }}</h2>
                            <h6>Time Order: {{ $orderDetails->order->created_at }}</h6>
                        
                        
                            @foreach ($orderDetails as $orderDetail)
                            <tr>
                                <th>{{ $orderDetails->food->id }}</th>
                                <td><img class="rounded-circle" height="75" width="75" src="{{ asset('/upload/food/' . $orderDetails->image) }}" alt=""></td>
                                <th>{{ $orderDetails->code }}</th>
                                <td>{{ $orderDetails->food->name }}</td>
                                <th>{{ $orderDetail->quantity }}</th>
                                <th>{{ $orderDetails->price }}</th>
                                <th>{{ $orderDetails->total_price }}</th>
                            </tr>
                            @endforeach
                            <!-- Add other details as needed -->

                            

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
