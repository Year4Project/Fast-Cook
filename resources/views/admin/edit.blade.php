@extends("layouts.app")

@section("content")

<div class="container-fluid">
    
    <!-- Content Row -->
    <div class="row align-items-end">

        <form method="post" action="">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name)}}" required placeholder="Name">
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email)}}" required placeholder="Email">
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