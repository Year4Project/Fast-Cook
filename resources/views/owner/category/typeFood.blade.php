@extends('layouts.app')

@section('content')
<div class="big-banner">
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category</h1>
        </div>

        {{-- Alert Massage --}}
        @include('_massage')

        {{-- Body --}}
        <div class="card shadow">
            {{-- title page --}}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h6 class="font-weight-bold text-primary">DataTables Of Category</h6>
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addnew">
                    <i class="bi bi-clipboard2-plus-fill"></i> Add New Category
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Create At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($category->isEmpty())
                                            <tr>
                                                <td colspan="11">
                                                    <div style="margin-top: 50px; text-align: center;">No records found.</div>
                                                </td>
                                            </tr>
                            @else
                            @foreach ($category as $item)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $item->name }}</td>
                                    <td class="align-middle">{{ date('d,M,Y | h:i A', strtotime($item->created_at)) }}</td>
                                    <td class="align-middle text-center">
                                        {{-- edit --}}
                                        <a class="btn btn-md btn-circle btn-outline-info"
                                            href="{{ url('owner/category/editCategory/' . $item->id) }}">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </a>
                                        {{-- delete --}}
                                        <a class="btn btn-md btn-circle btn-outline-danger ms-2"
                                            href="{{ url('owner/category/deleteCategory/' . $item->id) }}"
                                            onclick="return confirm('Are you Sure?')">
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
        @include('owner.category.createCategory')

    </div>
</div>
@endsection
