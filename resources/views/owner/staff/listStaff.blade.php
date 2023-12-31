@extends('layouts.app')

@section('content')
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
            <h1 class="h3 mb-0 text-gray-800">List Staff</h1>
            {{-- <a href="{{ url('owner/staff/createStaff') }}" 
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add Staff</a> --}}
            
        </div>

        @include('_massage')

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Of List Staff</h6>
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addnew">
                    <i class="bi bi-clipboard2-plus-fill"></i> Add New Employee
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>position</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getStaff as $staff)
                                <tr>
                                    <td>{{ $staff->id }}</td>
                                    <td class=""><img class="rounded-circle" height="75" width="75" src="/upload/staff/{{ $staff->image }}" alt=""></td>
                                    <td>{{ $staff->name }}</td>
                                    <td>{{ $staff->phone }}</td>
                                    <td>{{ $staff->gender }}</td>
                                    <td>{{ $staff->age }}</td>
                                    <td>{{ $staff->position }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-circle btn-outline-info" href="{{ url('owner/staff/edit',$staff->id) }}">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </a>

                                        <a class="btn btn-sm btn-circle btn-outline-danger ms-2" title="Delete" href="{{ url('owner/staff/delete/' . $staff->id) }} "
                                            onclick="return confirm('Are you Sure?')">
                                            <i class="fas fa-fw fa-trash-alt icon-trash-red"></i>
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
    @include('owner.staff.createStaff')
    {{-- @include('owner.staff.editStaff') --}}
@endsection
