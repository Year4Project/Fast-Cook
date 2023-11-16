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
                    <label>Restaurant Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $getRestaurant->name)}}" required>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $getRestaurant->email)}}" required>
                  </div>
                  <div class="form-group">
                    <label>Phone</label>
                    <input type="phone" class="form-control" name="phone" value="{{ old('phone', $getRestaurant->phone)}}" required >
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" name="address"  rows="5" required>{{ $getRestaurant->address }}</textarea>
                  </div>
                  <div class="form-group">
                    <label>Old Image Food </label>
                    @if(!empty($getRestaurant->getProfile()))
                      <img src="{{ $getRestaurant->getProfile() }}" style="width: 100px" alt="">
                    @endif
                    
                  </div>

                  <div class="form-group">
                    <label>New Image</label>
                    <input type="file" class="form-control" name="image">
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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
