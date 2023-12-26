@extends("layouts.app")

@section("content")

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 mb-4 mt-4">
          <div class="col-sm-6">
            <h1 class="h3 mb-0 text-gray-800">List Staff</h1>

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
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ old('name',$getStaff->name)}}" name="name" required placeholder="Enter Name">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label>Phone</label>
                        <input type="phone" class="form-control" value="{{ old('phone',$getStaff->phone)}}" name="phone" required placeholder="Enter Phone">
                        <div style="color: red">{{ $errors->first('phone')}}</div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option {{ (old('gender',$getStaff->gender) == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                                    <option {{ (old('gender',$getStaff->gender) == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                                    <option {{ (old('gender',$getStaff->gender) == 'Other') ? 'selected' : '' }} value="Other">Other</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label>Age</label>
                        <input type="num" class="form-control" value="{{ old('age',$getStaff->age)}}" name="age" required placeholder="Enter Age">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Position</label>
                    <select name="position" class="form-control" required>
                                <option value="">Select Position</option>
                                <option {{ (old('position',$getStaff->position) == 'Master') ? 'selected' : '' }} value="Master">Master Chef</option>
                                <option {{ (old('position',$getStaff->position) == 'Chef') ? 'selected' : '' }} value="Chef">Chef</option>
                                <option {{ (old('position',$getStaff->position) == 'Staff') ? 'selected' : '' }} value="Staff">Staff</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Old Image Staff</label>
                    <div class="container ms-2 mt-2 ">
                    <img height="150" width="150" src="/upload/staff/{{$getStaff->image}}" alt="">
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
