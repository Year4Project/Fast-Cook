@extends("layouts.app")

@section("content")

<div class="container-fluid">
    
    <!-- Content Row -->
    <div class="row align-items-end">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="h3 mb-0 text-gray-800">Add New Admin</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      
        <form method="post" action="">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" value="{{ old('first_name', $getRecord->first_name)}}" name="first_name" required placeholder="First Name">
              </div>
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" value="{{ old('last_name', $getRecord->last_name)}}" name="last_name" required placeholder="Last Name">
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $getRecord->email)}}" required placeholder="Email">
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                <input type="number" class="form-control" value="{{ old('phone', $getRecord->phone)}}" name="phone" required placeholder="Phone Number">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="text" class="form-control" name="password" placeholder="Password">
                <p>Do you want to change password so Please add new password</p>
            </div>


            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>

    </div>
</div>



@endsection