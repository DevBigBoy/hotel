<div class="tab-pane fade" id="roomimages" role="tabpanel">
    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-4">Room Gallery Image</h5>
            <form class="row g-3" method="POST" action="{{ route('admin.multi-images.store', $room->id) }}"
                enctype="multipart/form-data">

                @csrf

                <div class="col-md-12">

                    <label for="multiImg" class="form-label">Gallery Image </label>

                    <input type="file" name="multi_img[]" class="form-control" multiple id="multiImg"
                        accept="image/jpeg, image/jpg, image/gif, image/png">

                    <div class="row mt-2" id="preview_img"></div>

                </div>


                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table mb-0 table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($room->images as $image)
                        <tr>
                            <th scope="row">{{ $image->id }}</th>

                            <td>
                                <img src="{{ asset('storage/' . $image->image_path) }}" width="400px" alt="">
                            </td>

                            <td>
                                <form action="{{ route('admin.multi-images.destroy', [$room->id, $image->id]) }}"
                                    method="post" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('admin.multi-images.destroy', [$room->id, $image->id]) }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="btn btn-danger">
                                        <i class='bx bx-trash'></i> delete </a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-2">
                                No data available in table
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
