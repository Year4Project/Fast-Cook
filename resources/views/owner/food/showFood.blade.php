@extends("layouts.app")

@section("content")

<div class="container-fluid">


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">List Menu</h1>

        {{-- <a href="{{ url('owner/food/createFood/') }}"
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create Menu</a> --}}


    </div>

    @include('_massage')

    <div class="card shadow">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="font-weight-bold text-primary">DataTables Of Menu</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color: black">
                            <th>Code</th>
                            <th>Name</th>
                            <th>Original Price</th>
                            <th>Discound Price</th>
                            <th>Image</th>
                            <th>Stock</th>
                            <th>Create At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                   @foreach ($getRecord as $item)
                       <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->oPrice }}</td>
                            <td>{{ $item->dPrice }}</td>
                            <td><img height="75" width="75" src="/upload/food/{{$item->image}}" alt=""></td>
                            <td>
                                @if($item->status ==1)
                                <a href="{{ url('owner/food/updateStatus/'.$item->id) }}" onclick="return confirm('Are you Sure?')" class="btn btn-sm btn-success">Active</a>
                            @else
                            <a href="{{ url('owner/food/updateStatus/'.$item->id) }}" onclick="return confirm('Are you Sure?')" class="btn btn-sm btn-danger">InActive</a>
                            @endif
                            </td>
                            <td>{{ date('d,M,Y | h:i A', strtotime($item->created_at)) }}</td>
                            <td>
                                <a class="btn btn-sm btn-circle btn-outline-info" href="{{ url('owner/food/edit/'.$item->id) }}">
                                    <i class="fas fa-fw fa-edit"></i>
                                </a>

                                <a class="btn btn-sm btn-circle btn-outline-danger ms-2" href="{{ url('owner/food/delete/'.$item->id) }}">
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
    @include('owner.food.createFood')

</div>



@endsection
