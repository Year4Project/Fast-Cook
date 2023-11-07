@extends("layouts.app")

@section("content")

<div class="container-fluid">
    

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Restaurant</h1>
        <a href="{{ url('admin/restaurant/create') }}" 
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create Restaurant</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Of Restaurant</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color: black">
                            <th>Restaurant ID</th>
                            <th>Restaurant Name</th>
                            <th>Owner Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                                <tr>
                                   
                        @foreach ($data as $restaurant)
                                <td>{{ $restaurant->id }}</td>
                                <td>{{ $restaurant->restaurant_name }}</td>
                                <td>{{ $restaurant->first_name }} {{ $restaurant->last_name }}</td>
                                <td>{{ $restaurant->address }}</td>
                                <td>{{ $restaurant->email }}</td>
                                <td>{{ $restaurant->phone }}</td>
                                <td>
                                    <a class="nav-link" href="{{ url('admin/restaurant/edit/'.$restaurant->id) }}">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>
    
                                    <a class="nav-link" href="{{ url('admin/restaurant/delete/'.$restaurant->id) }}">
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



@endsection