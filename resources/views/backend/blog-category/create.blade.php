<div class="col">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">
        <i class='bx bx-plus'></i>
        New Category
    </button>

    <!-- Modal -->

    <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.blog_categories.store') }}">
                        @csrf

                        <!-- Title -->
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Name <span class="required text-danger">*</span>
                                </h6>
                            </div>

                            <div class="col-sm-9 text-secondary">
                                <input id="name" name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')])
                                    value="{{ old('name') }}">

                                @error('name')
                                    <span class="text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>


</div>
