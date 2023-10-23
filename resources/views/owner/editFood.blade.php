@extends("layouts.app")

@section("content")

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Food</h1>
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
              
			  <form method="post" action="{{ url('/owner/editFood',$menu->id) }}" enctype="multipart/form-data">
				@csrf
			  <div class="card-body">
				<div class="form-group">
				  <label>Name</label>
				  <input type="text" class="form-control" name="name" required value="{{$menu->name}}">
				</div>
				<div class="form-group">
				  <label>Code</label>
				  <input type="text" class="form-control" name="code" required value="{{$menu->code}}">
				  {{-- <div style="color: red">{{ $errors->first('email')}}</div> --}}
				</div>
				<div class="form-group">
					<label>Original Price</label>
					<input type="text" class="form-control" name="oPrice" required value="{{$menu->oPrice}} ">
				</div>
				<div class="form-group">
					<label>Discounted Price</label>
					<input type="text" class="form-control" name="dPrice" required value="{{$menu->dPrice}} ">
				</div>
				<div class="form-group">
					<label for="stock">Stock</label>
					<select name="stock" id="stock" class="form-control" name="" id="">
						<option value="0">Available</option>
						<option value="1">Unavailable</option>
					</select>
				</div>
				<div class="form-group">
					<label>Old Image</label>
					<img height="100" width="100" src="/foodimage/{{ $menu->image }}" alt="">
				</div>
				<div class="form-group">
					<label>Image</label>
					<input class="form-control" type="file" name="image">
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
