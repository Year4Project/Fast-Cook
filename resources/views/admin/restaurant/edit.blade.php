@extends("layouts.app")

@section("content")

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="h3 mb-0 text-gray-800">Add New Admin</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                          <div class="form-group">
                            <label>Restaurant Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $owner->restaurant->name)}}" required>
                          </div>
                          <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $owner->email)}}" required>
                          </div>
                          <div class="form-group">
                            <label>Phone</label>
                            <input type="phone" class="form-control" name="phone" value="{{ old('phone', $owner->phone)}}" required >
                          </div>
                          <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address"  rows="5" required>{{ $owner->restaurant->address }}</textarea>
                          </div>
                          <div class="form-group">
                            <label>Old Image Food </label>

                              <img src="{{ $owner->restaurant->image }}" style="width: 100px" alt="">


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
    </div>


    <!-- /.content -->
  </div>

  @endsection
