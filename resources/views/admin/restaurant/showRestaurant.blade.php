@extends("layouts.app")

@section("content")
<div class="big-banner">
<div class="container-fluid">
    @include('_massage')
    <div class="card shadow mb-4 mx-auto">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h3 class="m-0 font-weight-bold text-primary">DataTables Of Restaurant</h3>
            <a href="{{ url('admin/restaurant/create') }}"
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create Restaurant</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Image</th>
                            <th>Owner Name</th>
                            <th>Restaurant Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getRestaurant as $item)
                            <tr class="text-center">
                                <td class="align-middle">{{ $item->restaurant_id }}</td>
                                <td><img height="75" width="75" src="{{$item->image}}" alt=""></td>
                                <td class="align-middle">{{ $item->first_name }}{{ $item->last_name }}</td>
                                <td class="align-middle">{{ $item->restaurant_name }}</td>
                                <td class="align-middle">{{ $item->email }}</td>
                                <td class="align-middle">{{ $item->phone }}</td>
                                <td class="align-middle">{{ $item->restaurant_address }}</td>
                                <td class="align-middle text-center">
                                    {{-- edit --}}
                                    <a href="{{ route('restaurant.edit', ['id' => $item->restaurant_id]) }}" class="btn btn-md btn-circle btn-outline-info">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>                                    
                                    {{-- delete --}}
                                    <a class="btn btn-md btn-circle btn-outline-danger ms-2"
                                        href="{{ url('admin/restaurant/delete/'.$item->restaurant_id) }}"
                                        onclick="return confirm('Are you Sure?')">
                                        <i class="fas fa-fw fa-trash-alt"></i>
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
