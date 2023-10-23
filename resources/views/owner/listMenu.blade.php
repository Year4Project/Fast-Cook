@extends("layouts.app")

@section("content")

<div class="container-fluid">
    

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Food</h1>
        <a href="{{ url('owner/addFood') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Add Food</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Of Manager</h6>
        </div>
        @include('_massage')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="color: black">
                                <th>Name</th>
								<th>Item Code</th>
								<th>Original Price</th>
								<th>Discounted Price</th>
								<th>Item Image</th>
								<th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                   @foreach ($menu as $menuItem)
                        <tr>
                            <td>{{ $menuItem->name ?? 'None'}}</td>
                            <td>{{ $menuItem->code }}</td>
                            <td>{{ $menuItem->oPrice }}</td>
                            <td>{{ $menuItem->dPrice }}</td>
                            <td><img height="75" width="75" src="/foodimage/{{$menuItem->image}}" alt=""></td>
                            <td>
                                <a href="{{ url('owner/edit/'.$menuItem->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ url('owner/delete/'.$menuItem->id) }}" class="btn btn-danger">Delete</a>
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