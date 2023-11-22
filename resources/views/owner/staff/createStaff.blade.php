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
              <form method="post" action="{{ url ('owner/staff/store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ old('name')}}" name="name" required placeholder="Enter Name">
                  </div>
                  <div class="form-group">
                    <label>Phone</label>
                    <input type="phone" class="form-control" value="{{ old('phone')}}" name="phone" required placeholder="Enter Phone">
                    <div style="color: red">{{ $errors->first('phone')}}</div>
                  </div>
                  <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="">Male</option>
                                <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="">Female</option>
                                <option {{ (old('gender') == 'Other') ? 'selected' : '' }} value="">Other</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Age</label>
                    <input type="num" class="form-control" value="{{ old('age')}}" name="age" required placeholder="Enter Age">
                  </div>
                  <div class="form-group">
                    <label>Position</label>
                    <select name="postion" class="form-control" required>
                                <option value="">Select Position</option>
                                <option {{ (old('postion') == 'Male') ? 'selected' : '' }} value="">Master Chef</option>
                                <option {{ (old('postion') == 'Female') ? 'selected' : '' }} value="">Chef</option>
                                <option {{ (old('postion') == 'Other') ? 'selected' : '' }} value="">Staff</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Image</label>
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
