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
              <form method="post" action="{{ URL::to('admin/restaurant/store') }}">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Restaurant Name</label>
                    <input type="text" class="form-control" name="restaurant_name"  required>
                  </div>
                  <div class="form-group">
                    <label>Owner Name</label>
                    <select class="form-select" name="user" name="first_name">
                      @foreach($user as $user)
                          
                          <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                      @endforeach
                  </select>
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" name="address" id="address" rows="5" required value="{{ old('address', $restaurant->address)}}"></textarea>
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
