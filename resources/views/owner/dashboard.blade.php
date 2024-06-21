@extends('layouts.app')

@section('content')
    {{-- bg-dashboard --}}
    <div class="big-banner">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div class="ms-4">
                    <h1 class="m-0 text-8000" id="greeting"></h1>
                    {{-- <h2 id="greeting" class="m-0 font-weight-bold text-secondary"></h2> --}}
                </div>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>

            <!-- Content Row -->
            <div class="row justify-content-center">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ml-4">
                                    <div class="text-xl font-weight-bold text-secondary text-uppercase mb-1">
                                        Foods Category</div>
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
                                        Food PRODUCTS</div>
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
                                        Available Tables</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $getTables }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-border-all fa-2x text-black-300"></i>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                {{-- order --}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                        ACCEPTED ORDERS
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $acceptedOrderCount }}</div>

                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-check-circle fa-2x text-black-300"></i>
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
                                        PENDING ORDERS
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingOrderCount }}</div>

                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-smile fa-2x text-black-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-danger text-uppercase mb-1">
                                        REJECTED ORDERS
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rejectedOrderCount }}</div>

                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-window-close fa-2x text-black-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                        Total ORDERS
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
                {{-- End line total order --}}
            </div>
            {{-- payment --}}
            <div class="row justify-content-center">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                        Payment USD</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($getTotalOrder,2) }}</div>
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
                                        Payment Online</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($getTotalOrderOnline,2) }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-dollar-sign fa-2x text-black-300"></i>
                                    <h1 class="text-black-300 font-size, font-weight"></h1>
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
                                        Total Earnings</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format( ($getTotalOrder + $getTotalOrderOnline) * 4100) }}
                                    </div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-khr-sign fa-2x text-black-300">៛</i>
                                    <h1 class="text-black-300 font-size, font-weight"></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col ms-4">
                                    <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                        Total Earnings</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($getTotalOrder + $getTotalOrderOnline,2) }}</div>
                                </div>
                                <div class="col-auto me-4">
                                    <i class="fas fa-dollar-sign fa-2x text-black-300"></i>
                                    <h1 class="text-black-300 font-size, font-weight"></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Order Number</th>
                                        <th>User Name</th>
                                        <th>Table No</th>
                                        <th>Status</th>
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
                                        @php
                                            // Calculate the correct starting number based on the current page
                                            $perPage = $getOrderUser->perPage();
                                            $currentPage = $getOrderUser->currentPage();
                                            $startNumber = ($currentPage - 1) * $perPage + 1;
                                        @endphp
                                        @foreach ($getOrderUser as $index => $foodOrder)
                                            <tr class="text-center">
                                                <td class="align-middle">{{ $startNumber + $index }}</td>
                                                <td class="align-middle">{{ $foodOrder->ordernumber }}</td>
                                                <td class="align-middle">{{ $foodOrder->user->first_name }} {{ $foodOrder->user->last_name }}</td>
                                                <td class="align-middle">{{ $foodOrder->table_no }}</td>
                                                <td class="align-middle text-center">
                                                    @php
                                                        $statusClass = '';
                                                        switch ($foodOrder->status) {
                                                            case 'accepted':
                                                                $statusClass = 'bg-success';
                                                                break;
                                                            case 'pending':
                                                                $statusClass = 'bg-warning';
                                                                break;
                                                            case 'rejected':
                                                                $statusClass = 'bg-danger';
                                                                break;
                                                            default:
                                                                $statusClass = '';
                                                        }
                                                    @endphp
                                                    <select class="form-control {{ $statusClass }} text-center" onchange="updateStatus('{{ $foodOrder->id }}', this.value)">
                                                        <option class="bg-success" value="accepted" {{ $foodOrder->status == 'accepted' ? 'selected' : '' }}>
                                                            <i class="fas fa-check-circle"></i> Accepted
                                                        </option>
                                                        <option class="bg-warning" value="pending" {{ $foodOrder->status == 'pending' ? 'selected' : '' }}>
                                                            <i class="fas fa-clock"></i> Pending
                                                        </option>
                                                        <option class="bg-danger" value="rejected" {{ $foodOrder->status == 'rejected' ? 'selected' : '' }}>
                                                            <i class="fas fa-times-circle"></i> Rejected
                                                        </option>
                                                    </select>
                                                </td>
                                                <td class="align-middle">
                                                    @if ($foodOrder->payment_method)
                                                        {{ $foodOrder->payment_method->payment_type }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
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
@endsection
