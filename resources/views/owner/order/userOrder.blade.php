@extends('layouts.app')

@section('content')
<script>
    function updateStatus(orderId, newStatus) {
        var url = '/admin/order/updateOrderStatus/' + orderId + '/' + newStatus;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token if using Laravel
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success('Order status updated successfully.');
                setTimeout(function() {
                    window.location.reload();
                }, 1000); // Reload page after 1 second
            } else {
                toastr.error('Failed to update order status.');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            toastr.error('An error occurred while updating order status.');
        });
    }
</script>

<style>
    .bg-success {
        background-color: #28a745 !important;
        color: white;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: white;
    }

    .bg-danger {
        background-color: #dc3545 !important;
        color: white;
    }
</style>

<div class="big-banner">
    <div class="container-fluid">
        @include('_massage')

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Customer Orders From App</h3>
            </div>
            <div id="app">
                <order-component></order-component>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
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
                                @foreach ($getOrderUser as $foodOrder)
                                    <tr class="text-center">
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
                                                {{ $foodOrder->payment_method->type }}
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
@endsection
