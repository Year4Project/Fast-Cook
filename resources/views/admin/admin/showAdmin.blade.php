@extends("layouts.app")

@section("content")
<div class="big-banner">
<div class="container-fluid">


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Owner Restaurant</h1>
        <a href="{{ url('admin/admin/add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add Manager</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Of Owner Restaurant</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color: black">
                            <th>ID</th>
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
                            <td>{{ $adm->user_id }}</td>
                            <td>{{ $adm->first_name }}</td>
                            <td>{{ $adm->last_name }}</td>
                            <td>{{ $adm->email }}</td>
                            <td>{{ $adm->phone }}</td>
                            <td>{{ $adm->user_type  }}</td>

                            <td>
                                @if($adm->status ==1)
                                     <a href="{{ url('admin/admin/updateStatus/'.$adm->user_id) }}" onclick="return confirm('Are you Sure?')" class="btn btn-sm btn-success">Active</a>
                                 @else
                                 <a href="{{ url('admin/admin/updateStatus/'.$adm->user_id) }}" onclick="return confirm('Are you Sure?')" class="btn btn-sm btn-danger">InActive</a>
                                 @endif
                             </td>

                            <td>{{ date('d-m-Y H:i A', strtotime($adm->created_at)) }}</td>
                            <td>

                                <a class="nav-link" href="{{ url('admin/admin/edit/'.$adm->id) }}">
                                    <i class="fas fa-fw fa-edit"></i>
                                </a>
                                <a class="nav-link" href="{{ url('admin/admin/delete/'.$adm->id) }}">
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

</div>

@endsection
