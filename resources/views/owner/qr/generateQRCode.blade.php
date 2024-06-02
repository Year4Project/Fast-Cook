@extends('layouts.app')

@section('content')
    <div class="big-banner">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Generator QR Code</h1>
                {{-- <a href="{{ url('owner/qr/create') }}"
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create QR</a> --}}
            </div>

            <div class="card shadow mb-4 mt-4">
                <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Of QR Code</h6>
                    {{-- <a href="{{ url('owner/qr/create') }}"
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create QR</a> --}}
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addnew">
                        <i class="bi bi-clipboard2-plus-fill"></i> Generate QR Code Table
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mx-auto" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">#</th>
                                    <th class="text-center" scope="col">Table No</th>
                                    <th class="text-center" scope="col">Restaurant ID</th>
                                    <th class="text-center" scope="col">Qr Code</th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($getQrcode->isEmpty())
                                    <tr>
                                        <td colspan="11">
                                            <div style="margin-top: 50px; text-align: center;">No records found.</div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($getQrcode as $item)
                                        <tr class="text-center">
                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            <td class="align-middle">{{ $item->table_no }}</td>
                                            <td class="align-middle">{{ $item->restaurant_id }}</td>
                                            <td class="align-middle">
                                                {{-- <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->merge(asset('admin/img/logo.png'))->generate(json_encode(["restaurant_id" => $item->restaurant_id, "table_no" => $item->table_no]))) }}" alt=""> --}}
                                                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')
                                                ->merge(asset('admin/img/logo.png'), 0.3, true) // Adjust the size and center the logo
                                                ->size(200) // Set the size of the QR code
                                                ->errorCorrection('H') // Set the error correction level
                                                ->generate(json_encode(["restaurant_id" => $item->restaurant_id, "table_no" => $item->table_no]))) }}" alt="QR Code">
                                            

                                                {{-- {!! QrCode::size(100)->generate(json_encode(["restaurant_id" => $item->restaurant_id, "table_no" => $item->table_no])) !!} --}}
                                            </td>
                                            <td class="align-middle">

                                                {{-- download --}}
                                                <a class="btn btn-md btn-circle btn-primary ms-2"
                                                    href="{{ route('owner.qr.download', ['scen' => $item->id]) }}">
                                                    <i class="fas fa-download"></i>
                                                </a>

                                                {{-- <a href="{{ route('owner.qr.download', ['scen' => $item->id]) }}" class="btn btn-primary">Download QR Code</a><br> --}}
                                                {{-- <a href="{{ url('owner/qr/delete/'. $item->id) }}" class="btn btn-danger mt-2">Delete QR Code</a> --}}
                                                {{-- delete --}}
                                                <a class="btn btn-md btn-circle btn-outline-danger ms-2"
                                                    href="{{ url('owner/qr/delete-qrcode/' . $item->id) }}"
                                                    onclick="confirmation(event)">
                                                    <i class="fas fa-fw fa-trash-alt"></i>
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('owner.qr.create')
        </div>
    </div>
@endsection
