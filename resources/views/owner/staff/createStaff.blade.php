
<!-- Add Modal -->
<div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
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
                            <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                            <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                            <option {{ (old('gender') == 'Other') ? 'selected' : '' }} value="Other">Other</option>
                </select>
              </div>
              <div class="form-group">
                <label>Age</label>
                <input type="num" class="form-control" value="{{ old('age')}}" name="age" required placeholder="Enter Age">
              </div>
              <div class="form-group">
                <label>Position</label>
                <select name="position" class="form-control" required>
                            <option value="">Select Position</option>
                            <option {{ (old('position') == 'Master') ? 'selected' : '' }} value="Master">Master Chef</option>
                            <option {{ (old('position') == 'Chef') ? 'selected' : '' }} value="Chef">Chef</option>
                            <option {{ (old('position') == 'Staff') ? 'selected' : '' }} value="Staff">Staff</option>
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
</div>
