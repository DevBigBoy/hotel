<div class="tab-pane fade show active" id="bacis" role="tabpanel">
    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-4">New Room</h5>
            <form class="row g-3" method="POST" action="{{ route('admin.rooms.update', $room->id) }}"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="roomType" class="form-label">
                        Room Type
                        <span class="required text-danger">*</span>
                    </label>
                    <select id="roomType" class="form-select" name="room_type_id">
                        @foreach ($room_types as $room_type)
                            <option value="{{ $room_type->id }}" @selected($room->room_type_id == $room_type->id)>
                                {{ $room_type->name }}</option>
                        @endforeach
                    </select>

                    @error('room_type_id')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="roomType" class="form-label">
                        Status
                        <span class="required text-danger">*</span>
                    </label>
                    <select id="roomType" class="form-select" name="status">
                        <option @selected($room->status == 'available') value="available">available
                        </option>
                        <option @selected($room->status == 'archived') value="archived">archived</option>
                    </select>
                    @error('status')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <!-- -->
                <div class="col-md-4">
                    <label for="room_capacity" class="form-label">Room Capacity</label>
                    <input type="number" class="form-control" name="capacity" id="room_capacity"
                        placeholder="Room Capacity" value="{{ old('capacity', $room->capacity) }}">
                    @error('capacity')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="total_adults" class="form-label">Total Adult</label>
                    <input type="number" name="total_adults" class="form-control" id="total_adults"
                        placeholder="Total Adult" value="{{ old('total_adults', $room->total_adults) }}">
                    @error('total_adults')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="total_children" class="form-label">Total Child</label>
                    <input type="number" name="total_children" class="form-control" id="total_children"
                        placeholder="Total Child" value="{{ old('total_children', $room->total_children) }}">
                    @error('total_children')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>
                <!-- -->

                <div class="row text-center mt-3">
                    <h5>Main Image <span class="required text-danger">*</span>
                    </h5>
                </div>

                <!-- Image -->
                <div class="col-md-12 mt-0">
                    <div id="image-preview" class="image-preview">
                        <label for="image-upload" id="image-label">
                            <i class='bx bx-image-add bx-lg bx-tada-hover'></i>
                        </label>
                        <input type="file" name="image" id="image-upload" />
                    </div>

                    @error('image')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="short_desc" class="form-label">Short Description</label>
                    <textarea class="form-control" name="short_desc" id="short_desc" placeholder="Short Description..." rows="3">
                        {{ $room->short_desc }}
                    </textarea>
                    @error('short_desc')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="description" class="form-label">Long Description</label>
                    <x-forms.tinymce-editor name="description" value="{!! $room->description !!}" />

                    @error('description')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>



                <div class="col-md-6">
                    <label for="input7" class="form-label">
                        Bed Style <span class="required text-danger">*</span>
                    </label>
                    <select id="input7" class="form-select" name="bed_style">
                        <option @selected($room->bed_style == 'queen') value="queen">Queen Bed</option>
                        <option @selected($room->bed_style == 'twin') value="twin">Twin Bed</option>
                        <option @selected($room->bed_style == 'king') value="king">King Bed</option>
                    </select>
                    @error('bed_style')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="view" class="form-label">
                        Room View <span class="required text-danger">*</span>
                    </label>
                    <select id="view" class="form-select" name="view">
                        <option @selected($room->view == 'see') value="see">Sea View</option>
                        <option @selected($room->view == 'hill') value="hill">Hill View</option>
                    </select>
                    @error('view')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <!-- -->
                <div class="col-md-4">
                    <label for="price" class="form-label">Room Price <span
                            class="required text-danger">*</span></label>
                    <input type="number" name="price_per_night" @class([
                        'form-control',
                        'is-invalid' => $errors->has('price_per_night'),
                    ]) id="price"
                        placeholder="Room Price" value="{{ old('price_per_night', $room->price_per_night) }}">
                    @error('price_per_nights')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="discount" class="form-label">Discount % </label>
                    <input type="number" @class(['form-control', 'is-invalid' => $errors->has('discount')]) id="discount" name="discount"
                        placeholder="discount %" value="{{ old('discount', $room->discount) }}">

                    @error('discount')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>
                <!-- -->
                <div class="col-md-4">
                    <label for="size" class="form-label">Size <span class="required text-danger">*</span></label>
                    <input type="text" name="size" @class(['form-control', 'is-invalid' => $errors->has('size')]) id="size"
                        placeholder="size" value="{{ old('size', $room->size) }}">

                    @error('size')
                        <span class="text text-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="facilities" class="form-label">Select Facilities</label>

                    <div id="facilities">
                        @foreach ($facilities as $facility)
                            <div class="form-check form-check-info">
                                <input type="checkbox" class="form-check-input" name="facilities[]"
                                    value="{{ $facility->id }}" @checked(isset($room) && $room->facilities->pluck('id')->contains($facility->id))
                                    id="facility{{ $facility->id }}">

                                <label class="form-check-label" for="facility{{ $facility->id }}">
                                    {{ $facility->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary px-4">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
