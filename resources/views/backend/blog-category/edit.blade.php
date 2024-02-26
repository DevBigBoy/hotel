<div class="modal fade" id="category" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('admin.blog_categories.update', $category->id) }}">
                    @csrf
                    @method('PUT')
                    <!-- Title -->
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Name <span class="required text-danger">*</span>
                            </h6>
                        </div>

                        <div class="col-sm-9 text-secondary">
                            <input id="name" name="name" id="cat" type="text"
                                value="{{ old('name', $category->name) }}" @class(['form-control', 'is-invalid' => $errors->has('name')])>

                            @error('name')
                                <span class="text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
