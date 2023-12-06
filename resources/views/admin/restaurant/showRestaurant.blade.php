@extends("layouts.app")

@section("content")

<div class="container-fluid">


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">List Restaurant</h1>

    </div>
    @include('_massage')
    <div class="card shadow mb-4 mx-auto">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Of Restaurant</h6>
            <a href="{{ url('admin/restaurant/create') }}"
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create Restaurant</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="10">
                    <thead>
                        <tr style="color: black">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getRestaurant as $restaurant)
                            <tr>
                                <td style="color: black">{{ $restaurant->id }}</td>
                                <td>{{ $restaurant->name }}</td>
                                <td>{{ $restaurant->email }}</td>
                                <td>{{ $restaurant->phone }}</td>
                                <td>{{ $restaurant->address }}</td>
                                <td><img height="75" width="75" src="/upload/profile/{{$restaurant->image}}" alt=""></td>
                            <td>
                                    <a class="nav-link" href="{{ url('admin/restaurant/edit/'.$restaurant->id) }}">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>
                                    <a class="nav-link" href="{{ url('admin/restaurant/delete/'.$restaurant->id) }}" onclick="return confirm('Are you Sure?')">
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
