@extends("layouts.app")

@section("content")

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Admin</h1>
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
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ old('name', $menu->name)}}" name="name" required>
                  </div>
                  <div class="form-group">
                    <label>Code</label>
                    <input type="num" class="form-control" value="{{ old('code',$menu->code)}}" name="code" required>
                  </div>
                  <div class="form-group">
                    <label>Original Price</label>
                    <input type="number" class="form-control" value="{{ old('oPrice',$menu->oPrice)}}" name="oPrice" required>
                    {{-- <div style="color: red">{{ $errors->first('email')}}</div> --}}
                  </div>
                  <div class="form-group">
                    <label>Discound Price</label>
                    <input type="number" class="form-control" value="{{ old('dPrice',$menu->dPrice)}}" name="dPrice" required>
                  </div>
                  <div class="form-group">
                    <label>Old Image Food</label>
                    <img height="200" width="200" src="/foodimage/{{$menu->image}}" alt="">
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
