@extends('layouts.app')

@section('content')
    <div class="big-banner">
        <div class="container-fluid">

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                    <h3 class="m-0 font-weight-bold text-primary">List Admin</h3>
                    <a href="{{ url('admin/admin/add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add
                        Manager</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr style="color: black">
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Fisrt Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>User Type</th>
                                    <th>Status</th>
                                    <th>Create Data</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecord as $adm)
                                    <tr>
                                        <td class="align-middle">{{ $adm->user_id }}</td>
                                        <td class="align-middle"><img class="rounded-circle" height="75" width="75"
                                                src="{{ $adm->image_url }}" alt=""></td>
                                        <td class="align-middle">{{ $adm->first_name }}</td>
                                        <td class="align-middle">{{ $adm->last_name }}</td>
                                        <td class="align-middle">{{ $adm->email }}</td>
                                        <td class="align-middle">{{ $adm->phone }}</td>
                                        <td class="align-middle text-center">{{ $adm->user_type }}</td>

                                        <td class="align-middle text-center">
                                            @if ($adm->status == 1)
                                                <a href="{{ url('admin/admin/updateStatus/' . $adm->user_id) }}"
                                                    onclick="return confirm('Are you Sure?')"
                                                    class="btn btn-sm btn-success">Active</a>
                                            @else
                                                <a href="{{ url('admin/admin/updateStatus/' . $adm->user_id) }}"
                                                    onclick="return confirm('Are you Sure?')"
                                                    class="btn btn-sm btn-danger">InActive</a>
                                            @endif
                                        </td>

                                        <td class="align-middle">{{ date('d-m-Y H:i A', strtotime($adm->created_at)) }}</td>
                                        <td class="align-middle">

                                            <a class="btn btn-md btn-circle btn-outline-info" href="{{ url('admin/admin/edit/' . $adm->id) }}">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                            <form action="">
                                                <a class="btn btn-md btn-circle btn-outline-danger mt-2" href="{{ url('admin/admin/delete/' . $adm->id) }}">
                                                <i class="fas fa-fw fa-trash-alt icon-trash-red"></i>
                                            </a>
                                            </form>
                                            

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
