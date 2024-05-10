@extends('layouts.app')

@section('content')
<div class="big-banner">
    <div class="container-fluid">

        {{-- Alert Massage --}}
        @include('_massage')

        {{-- Body --}}
        <div class="card shadow">
            {{-- title page --}}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h3 class="font-weight-bold text-primary">Category</h3>
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addnew">
                    <i class="bi bi-clipboard2-plus-fill"></i> Add New Category
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Create At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($getCategories->isEmpty())
                                            <tr>
                                                <td colspan="11">
                                                    <div style="margin-top: 50px; text-align: center;">No records found.</div>
                                                </td>
                                            </tr>
                            @else
                            @foreach ($getCategories as $item)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $item->name }}</td>
                                    <td class="align-middle">{{ date('D d M Y | h:i A', strtotime($item->created_at)) }}</td>
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
                    <div class="row">
                        {{ $getCategories->links() }}
                    </div>
                </div>
            </div>
        </div>
        @include('owner.category.createCategory')

    </div>
</div>
@endsection
