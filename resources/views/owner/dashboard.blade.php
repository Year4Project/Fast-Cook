@extends('layouts.app')

@section('content')
    {{-- bg-dashboard --}}
    <div class="big-banner">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div class="ms-4">
                    <h2 class="m-0 font-weight-bold text-secondary">Good Morning!</h2>
                    {{-- <h4 class="mb-0 text-primary text-300 ms-4">{{ Auth::user()->restaurant->name }}</h4> --}}

                </div>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>

            <!-- Content Row -->
            <div class="row justify-content-center">
                <!-- Earnings (Monthly) Card Example -->

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ml-4">
                                    <div class="text-xl font-weight-bold text-secondary text-uppercase mb-1">
                                        Category</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $getCategory }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-border-all fa-2x text-black-300"></i>

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

                <div class="col-xl-3 col-md-6 mb-4">
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
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ml-4">
                                    <div class="text-xl font-weight-bold text-secondary text-uppercase mb-1">
                                        Tables</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $getTables }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-border-all fa-2x text-black-300"></i>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Earnings (Monthly) Card Example -->


                <!-- Pending Requests Card Example -->

            </div>


            <div class="row mt-4 justify-content-center">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                        ORDERS
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $getOrder }}</div>

                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-clipboard-list fa-2x text-black-300"></i>
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
                                        Payment USD</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $payment['USD'] }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-dollar-sign fa-2x text-black-300"></i>
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
                                        Payment KHR</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $payment['KHR'] }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-khr-sign fa-2x text-black-300"></i>
                                    <h1 class="text-black-300 font-size, font-weight">៛</h1>
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
                                        Total Sale</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $payment['TOTAL'] }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-khr-sign fa-2x text-black-300"></i>
                                    <h1 class="text-black-300 font-size, font-weight">៛</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                        dd</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $getStaff }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-user fa-2x text-blue-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="row mt-2 justify-content-center">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-2">
                            <h4 class="m-0 font-weight-bold text-primary">Today New Order</h4>
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
        </div>
    </div>
@endsection
