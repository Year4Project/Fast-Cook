@extends('layouts.app')

@section('content')
    <div class="big-banner">
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
                <div class="ms-4">
                    <h2 id="greeting" class="m-0 font-weight-bold text-secondary"></h2>
                </div>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>



            <!-- Content Row -->
            <div class="row justify-content-center">
                <!-- Earnings (Monthly) Card Example -->

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ml-4">
                                    <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                        Administrator</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_admin }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-users fa-2x text-black-300"></i>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                        Restaurant Available</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $restauran_available }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-store fa-2x text-black-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-warning text-uppercase mb-1">
                                        Restaurant Pending</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $restauran_pending }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-store fa-2x text-black-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                        Users</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_user }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-users fa-2x text-black-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>


        </div>
    </div>
@endsection
