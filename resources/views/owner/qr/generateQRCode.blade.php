@extends("layouts.app")

@section("content")

<div class="container-fluid">
    

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Generator QR Code</h1>
        <a href="{{ url('owner/qr/create') }}" 
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create QR</a>
    </div>
  
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Of Owner Restaurant</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color: black">
                            <th>#</th>
                            <th>Table No</th>
                            <th>Restaurant ID</th>
                            <th>Qr Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($scen as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->table_no }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{!! DNS2D::getBarcodeHTML("{restaurant_id: $item->id, table_no: $item->table_no}",'QRCODE') !!}
                                <td><a href="#">Download</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



@endsection