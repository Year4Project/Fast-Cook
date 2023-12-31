@extends("layouts.app")

@section("content")

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 mb-4 mt-4">
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
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" value="{{ old('price',$getRecord->oPrice)}}" name="price" required>
                        {{-- <div style="color: red">{{ $errors->first('email')}}</div> --}}
                      </div>
                      
                    </div>
                    {{-- <div class="col-6">
                      <div class="form-group">
                        <label>Discound Price</label>
                        <input type="number" class="form-control" value="{{ old('dPrice',$getRecord->dPrice)}}" name="dPrice" required>
                      </div>
                    </div> --}}
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" value="{{ old('description',$getRecord->description)}}" name="description" required placeholder="Enter Description">
                  </div>
                  <div class="form-group">
                    <label>Old Image Food</label>
                    <div class="container ms-2 mt-2 ">
                      <img height="150" width="150" src="/upload/food/{{$getRecord->image}}" alt="">
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

  @endsection
