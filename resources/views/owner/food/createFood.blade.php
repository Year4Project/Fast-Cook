<!-- Add Modal -->
<div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Food</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('owner/food/store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                required placeholder="Name Food">
                        </div>
                        {{-- <div class="form-group">
                    <label>Code</label>
                    <input type="num" class="form-control" value="{{ old('code')}}" name="code" required placeholder="Code Food">
                  </div> --}}
                        <div class="form-group">
                            <label>Original Price</label>
                            <input type="num" class="form-control" value="{{ old('oPrice') }}" name="oPrice"
                                required placeholder="Original Price">
                            {{-- <div style="color: red">{{ $errors->first('email')}}</div> --}}
                        </div>
                        <div class="form-group">
                            <label>Discound Price</label>
                            <input type="number" class="form-control" value="{{ old('dPrice') }}" name="dPrice"
                                required placeholder="Discound Price">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" value="{{ old('description') }}"
                                name="description" required placeholder="Enter Description">
                        </div>
                        <div class="form-group">
                            <label>Image Food</label>
                            <input type="file" class="form-control" name="image" required>
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
