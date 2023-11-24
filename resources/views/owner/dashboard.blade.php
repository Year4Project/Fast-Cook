@extends('layouts.app')

@section('content')

    <div class="big-banner">
        <div class="container-fluid">

        
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mt-4 mb-0 text-black-800">Dashboard</h1>
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
                                    Staff</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $getStaff }}</div>
                            </div>
                            <div class="col-auto me-4">
                                <i class="fas fa-user fa-2x text-blue-300"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $getFood }}</div>
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
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col ms-4">
                                <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                    ORDERS
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $getOrder }}</div>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
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
                                <thead>
                                    <tr style="color: black">
                                        <th>#</th>
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
                                    <td>{{ date('d,M,Y | h:i A', strtotime($orders->created_at)) }}</td>
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
        </div>
    </div>
    </div>
    
@endsection
