@extends('layouts.app')

@section('content')
<div class="big-banner">
    <div class="container-fluid">


        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
            <h1 class="h3 mb-0 text-gray-800">List Menu</h1>
        </div>

        {{-- Alert Massage --}}
        @include('_massage')

        <div class="row mt-4 justify-content-center">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-body ">
                        <div class="profile-image-container">
                            <form method="post" action="{{ url('owner/food/store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                            required placeholder="Name Food">
                                    </div>
                                    <div class="form-group">
                                        <label>Type of Food</label>
                                        <select class="form-control" name="category_id" required>
                                            <option value="">Select Type</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="num" class="form-control" value="{{ old('price') }}" name="price"
                                            required placeholder="Original Price">
                                        {{-- <div style="color: red">{{ $errors->first('email')}}</div> --}}
                                    </div>
                                    {{-- <div class="form-group">
                                        <label>Discound Price</label>
                                        <input type="number" class="form-control" value="{{ old('dPrice') }}" name="dPrice"
                                            required placeholder="Discound Price">
                                    </div> --}}
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control" value="{{ old('description') }}"
                                            name="description" required placeholder="Enter Description">
                                    </div>
                                    <div class="form-group">
                                        <label>Image Food</label>
                                        <input type="file" class="form-control" name="image" required>
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Body --}}

        {{-- @include('owner.food.createFood') --}}

    </div>
    </div>
@endsection

<!-- Add Modal -->
{{-- <div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Food</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div> --}}
