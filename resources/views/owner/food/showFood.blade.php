@extends('layouts.app')

@section('content')
<div class="big-banner">
    <div class="container-fluid">


        <!-- Page Heading -->
        {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Foods Menu</h1>
        </div> --}}

        {{-- Alert Massage --}}
        @include('_massage')

        {{-- Body --}}
        <div class="card shadow">
            {{-- title page --}}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h3 class="font-weight-bold text-primary">DataTables Of Menu</h3>
                <a href="{{ url('owner/food/createFood') }}" type="button" class="btn btn-primary float-end">
                    <i class="bi bi-clipboard2-plus-fill"></i> Add New Food
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Code</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Stock</th>
                                <th>Create At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($getFood->isEmpty())
                                <tr>
                                    <td colspan="11">
                                        <div style="margin-top: 50px; text-align: center;">No records found.</div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($getFood as $item)
                                    <tr class="text-center">
                                        <td class="align-middle">{{ $item->id }}</td>
                                        <td class="align-middle">{{ $item->code }}</td>
                                        <td><img class="rounded-circle align-middle" height="75" width="75"
                                                src="{{ $item->image_url }}" alt=""></td>
                                        <td class="align-middle">{{ $item->name }}</td>
                                        <td class="align-middle">${{ $item->price }}</td>
                                        <td class="align-middle">{{ $item->description }}</td>
                                        <td class="align-middle">
                                            {{ $item->category_name ?? 'No Category' }}
                                        </td>
                                        <td class="align-middle">
                                            @if ($item->status == 1)
                                                <a href="{{ route('update.Status', ['id' => $item->id]) }}"
                                                    class="btn btn-sm btn-success">Available</a>
                                            @else
                                                <a href="{{ route('update.Status', ['id' => $item->id]) }}"
                                                    class="btn btn-sm btn-danger">Unavailable</a>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ date('D d M Y | h:i A', strtotime($item->created_at)) }}</td>
                                        <td class="align-middle text-center">
                                            {{-- edit --}}
                                            <a class="btn btn-md btn-circle btn-outline-info"
                                                href="{{ url('owner/food/edit/' . $item->id) }}">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                            {{-- delete --}}
                                            <form action="">
                                            <a class="btn btn-md btn-circle btn-outline-danger mt-2"
                                                href="{{ url('owner/food/delete/' . $item->id) }}"
                                                onclick="return confirm('Are you Sure?')">
                                                <i class="fas fa-fw fa-trash-alt"></i>
                                            </a>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="row">
                        {{ $getFood->links() }}
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('owner.food.createFood') --}}

    </div>
</div>
@endsection
