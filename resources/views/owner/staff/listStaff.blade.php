@extends('layouts.app')

@section('content')
    <div class="big-banner">
        <div class="container-fluid">

            @include('_massage')

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                    <h3 class="m-0 font-weight-bold text-primary">DataTables Of List Staff</h3>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addnew">
                        <i class="bi bi-clipboard2-plus-fill"></i> Add New Employee
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
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
                                @if ($getStaff->isEmpty())
                                    <tr>
                                        <td colspan="11">
                                            <div style="margin-top: 50px; text-align: center;">No records found.</div>
                                        </td>
                                    </tr>
                                @else
                                @php
                                // Calculate the correct starting number based on the current page
                                $perPage = $getStaff->perPage();
                                $currentPage = $getStaff->currentPage();
                                $startNumber = ($currentPage - 1) * $perPage + 1;
                            @endphp
                                    @foreach ($getStaff as $index=> $staff)
                                        <tr class="text-center">
                                            <td class="align-middle">{{ $startNumber + $index }}</td>
                                            <td class="align-middle"><img class="img-thumbnail"
                                                    style="max-width: 75px; max-height:75px:" src="{{ $staff->image }}"
                                                    alt=""></td>
                                            <td class="align-middle">{{ $staff->name }}</td>
                                            <td class="align-middle">{{ $staff->phone }}</td>
                                            <td class="align-middle">{{ $staff->gender }}</td>
                                            <td class="align-middle">{{ $staff->age }}</td>
                                            <td class="align-middle">{{ $staff->position }}</td>
                                            <td class="align-middle">
                                                <a class="btn btn-md btn-circle btn-outline-info"
                                                    href="{{ url('owner/staff/edit', $staff->id) }}">
                                                    <i class="fas fa-fw fa-edit"></i>
                                                </a>

                                                <br>

                                                <a class="btn btn-md btn-circle btn-outline-danger mt-2" title="Delete"
                                                    href="{{ url('owner/staff/delete/' . $staff->id) }} "
                                                    onclick="confirmation(event)">
                                                    <i class="fas fa-fw fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="row">
                            {{ $getStaff->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('owner.staff.createStaff')
    {{-- @include('owner.staff.editStaff') --}}
    </div>
@endsection
