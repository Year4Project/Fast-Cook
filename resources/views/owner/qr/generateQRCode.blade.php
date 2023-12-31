@extends("layouts.app")

@section("content")

<div class="container-fluid">
    

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">Generator QR Code</h1>
        {{-- <a href="{{ url('owner/qr/create') }}" 
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create QR</a> --}}
    </div>
  
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Of Owner Restaurant</h6>
            {{-- <a href="{{ url('owner/qr/create') }}" 
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create QR</a> --}}
        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addnew">
            <i class="bi bi-clipboard2-plus-fill"></i> Generate QR Code Table
          </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mx-auto table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Table No</th>
                            <th class="text-center" scope="col">Qr Code</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getQrcode as $item)
                            <tr>
                                <td class="text-center">{{ $item->id }}</td>
                                <td class="text-center">{{ $item->table_no }}</td>
                                <td class="text-center">{!! QrCode::size(100)->generate(json_encode(["restaurant_id" => $item->id, "table_no" => $item->table_no])) !!}</td>
                                <td class="text-center">
                                    <a href="{{ route('owner.qr.download', ['scen' => $item->id]) }}" class="btn btn-primary">Download QR Code</a><br>
                                    <a href="{{ url('owner/qr/delete/'. $item->id) }}" class="btn btn-danger mt-2">Delete QR Code</a>
                                    
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('owner.qr.create')
</div>




@endsection