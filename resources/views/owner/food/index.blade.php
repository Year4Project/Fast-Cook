@extends("layouts.app")

@section("content")

<div class="container-fluid">
    

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Menu</h1>
        <a href="{{ url('owner/food/create') }}" 
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add Menu</a>
    </div>

    @include('_massage')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Of Menu</h6>
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
                   @foreach ($menu as $item)
                       <tr>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->oPrice }}</td>
                            <td>{{ $item->dPrice }}</td>
                            <td><img height="75" width="75" src="/foodimage/{{$item->image}}" alt=""></td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ date('d-m-Y H:i A', strtotime($item->created_at)) }}</td>
                            <td>
                                <a class="nav-link" href="{{ url('owner/food/edit/'.$item->id) }}">
                                    <i class="fas fa-fw fa-edit"></i>
                                </a>

                                <a class="nav-link" href="{{ url('owner/food/delete/'.$item->id) }}">
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