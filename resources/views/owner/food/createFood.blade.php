@extends("layouts.app")

@section("content")

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Food</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ url ('owner/food/store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ old('name')}}" name="name" required placeholder="Name Food">
                  </div>
                  {{-- <div class="form-group">
                    <label>Code</label>
                    <input type="num" class="form-control" value="{{ old('code')}}" name="code" required placeholder="Code Food">
                  </div> --}}
                  <div class="form-group">
                    <label>Original Price</label>
                    <input type="num" class="form-control" value="{{ old('oPrice')}}" name="oPrice" required placeholder="Original Price">
                    {{-- <div style="color: red">{{ $errors->first('email')}}</div> --}}
                  </div>
                  <div class="form-group">
                    <label>Discound Price</label>
                    <input type="number" class="form-control" value="{{ old('dPrice')}}" name="dPrice" required placeholder="Discound Price">
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" value="{{ old('description')}}" name="description" required placeholder="Enter Description">
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
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  @endsection
