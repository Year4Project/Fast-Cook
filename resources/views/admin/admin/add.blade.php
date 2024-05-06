@extends("layouts.app")

@section("content")
<div class="big-banner">
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <!-- left column -->
          <div class="col-md-8">
            <div class="card-header">
            <h3>Add New Admin</h3>
            </div>
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" value="{{ old('first_name')}}" name="first_name" required placeholder="First Name">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" value="{{ old('last_name')}}" name="last_name" required placeholder="Last Name">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Image Food</label>
                    <input type="file" class="form-control" name="image" required>
                </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{ old('email')}}" name="email" required placeholder="Email">
                    <div style="color: red">{{ $errors->first('email')}}</div>
                  </div>
                  <div class="form-group">
                    <label>Phone Number</label>
                    <input type="number" class="form-control" value="{{ old('phone')}}" name="phone" required placeholder="Phone Number">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required placeholder="Password">
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
