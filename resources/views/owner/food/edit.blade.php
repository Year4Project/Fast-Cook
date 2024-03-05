@extends("layouts.app")

@section("content")
<div class="big-banner">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="h3 mb-0 text-gray-800">Add New Admin</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content ">
      <div class="container-fluid">
          <div class="row justify-content-center">
          <!-- left column -->
          <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ old('name', $getRecord->name)}}" name="name" required>
                  </div>
                  {{-- {{ dd($getFood) }} --}}
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" value="{{ old('price',$getRecord->price)}}" name="price" required>
                        {{-- <div style="color: red">{{ $errors->first('email')}}</div> --}}
                      </div>

                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Type of Food</label>
                            <select class="form-control" name="category_id" required>
                                {{-- <option value="">Select Type</option> --}}
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $getRecord->category_id == $category->id ? 'selected':'' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" value="{{ old('description',$getRecord->description)}}" name="description" required placeholder="Enter Description">
                  </div>
                  <div class="form-group">
                    <label>Old Image Food</label>
                    <div class="container ms-2 mt-2 ">
                      <img height="150" width="150" src="{{$getRecord->image_url}}" alt="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Image Food</label>
                    <input type="file" class="form-control" name="image">
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
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
  @endsection
