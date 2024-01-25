@extends('layouts.app')

@section('content')
    <div class="big-banner bg-dashboard">
        <div class="container-fluid">

            <!-- Include Laravel Echo and Pusher -->
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.1/dist/echo.iife.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ config('broadcasting.connections.pusher.key') }}',
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        encrypted: true,
    });

    Echo.channel('restaurant-dashboard')
        .listen('NewOrderPlaced', (event) => {
            // Handle the new order event and update the dashboard
            console.log('New Order Placed:', event);
            // Add your logic to update the dashboard here
        });
</script>


            {{-- <order-notification></order-notification> --}}

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"></h1>
                <a href="#" class="d-none mt-4 d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>

            <!-- Content Row -->
            <div class="row justify-content-center">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                        Restaurant</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRestaurant }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-utensils fa-2x text-black-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                        PRODUCTS</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                                <div class="col-auto me-4">


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ml-4">
                                    <div class="text-xl font-weight-bold text-secondary text-uppercase mb-1">
                                        Tables</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-border-all fa-2x text-black-300"></i>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                        ORDERS
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    {{-- <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div> --}}
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-clipboard-list fa-2x text-black-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-warning text-uppercase mb-1">
                                        SALES</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-dollar-sign fa-2x text-black-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 justify-content-center">
                <div class="col-11">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Of User Order</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>User Name</th>
                                            <th>Table No</th>
                                            <th>Remark</th>
                                            <th>Quantity</th>
                                            <th>Payment</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Laravel Echo and Pusher -->
{{-- <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.1/dist/echo.iife.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
    Echo.channel('new-order')
        .listen('NewOrderPlaced', (event) => {
            // Handle the new order event and update the dashboard
            console.log('New Order Placed:', event);
            // Add your logic to update the dashboard here
        });
</script> --}}
{{-- <script src="{{ mix('js/app.js') }}"></script> --}}

@endsection
