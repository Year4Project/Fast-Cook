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
								@csrf
							  <div class="card-body">
								<div class="form-group">
								  <label>Name</label>
								  <input type="text" class="form-control" name="name" required placeholder="Name">
								</div>
								<div class="form-group">
								  <label>Code</label>
								  <input type="text" class="form-control" name="code" required placeholder="Enter Code Food">
								  {{-- <div style="color: red">{{ $errors->first('email')}}</div> --}}
								</div>
								<div class="form-group">
									<label>Original Price</label>
									<input type="text" class="form-control" name="oPrice" required placeholder="Original Price">
								</div>
								<div class="form-group">
									<label>Discounted Price</label>
									<input type="text" class="form-control" name="dPrice" required placeholder="Discounted Price">
								</div>
								<div class="form-group">
									<label for="stock">Stock</label>
                					<select name="stock" id="stock" class="form-control" name="" id="">
										<option value="0">Available</option>
										<option value="1">Unavailable</option>
									</select>
								</div>
								<div class="form-group">
									<label>Image</label>
                					<input class="form-control" type="file" name="image" placeholder="Image" required>
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
