@extends('backend.layouts.master')

@section('page-title', 'Rooms')


@push('styles')
    <style type="text/css">
        #image-preview {
            width: 450px;
            height: 300px;
            position: relative;
            overflow: hidden;
            background-color: #e2e2e2;
            color: #fff;
            box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
            margin: 0.5rem auto;
            border-radius: 5%;
        }

        #image-preview input {
            line-height: 200px;
            font-size: 2rem;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }

        #image-preview label {
            position: absolute;
            z-index: 15;
            cursor: pointer;
            height: 50px;
            line-height: 50px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            text-align: center;
        }
    </style>
@endpush


@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Rooms</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Room</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group gap-2">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-success ">
                        <i class='bx bx-arrow-back bx-fade-left-hover'></i>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-12 col-md-12 mx-auto mt-3">
                <h6 class="mb-0 text-uppercase">Primary Nav Tabs</h6>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab"
                                    aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bx bx-home font-18 me-1"></i>
                                        </div>
                                        <div class="tab-title">Home</div>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#roomimages" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon">
                                            <i class="bx bx-images font-18 me-1"></i>
                                        </div>
                                        <div class="tab-title">Room Images</div>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
                                        </div>
                                        <div class="tab-title">Profile</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">

                                <div class="card">
                                    <div class="card-body p-4">
                                        <h5 class="mb-4">New Room</h5>
                                        <form class="row g-3" method="POST" action="{{ route('admin.rooms.store') }}"
                                            enctype="multipart/form-data">

                                            @csrf

                                            <div class="col-md-6">
                                                <label for="roomType" class="form-label">
                                                    Room Type
                                                    <span class="required text-danger">*</span>
                                                </label>
                                                <select id="roomType" class="form-select" name="room_type_id">
                                                    <option value="">Choose...</optionv>
                                                        @foreach ($room_types as $room_type)
                                                    <option value="{{ $room_type->id }}">{{ $room_type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="roomType" class="form-label">
                                                    Status
                                                    <span class="required text-danger">*</span>
                                                </label>
                                                <select id="roomType" class="form-select" name="status">
                                                    <option value="">Choose...</option>
                                                    <option value="available">available</option>
                                                    <option value="archived">archived</option>

                                                </select>
                                            </div>

                                            <!-- -->
                                            <div class="col-md-4">
                                                <label for="room_capacity" class="form-label">Room Capacity</label>
                                                <input type="number" class="form-control" name="capacity"
                                                    id="room_capacity" placeholder="Room Capacity">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="total_adults" class="form-label">Total Adult</label>
                                                <input type="number" name="total_adults" class="form-control"
                                                    id="total_adults" placeholder="Total Adult">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="total_children" class="form-label">Total Child</label>
                                                <input type="number" name="total_children" class="form-control"
                                                    id="total_children" placeholder="Total Child">
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
                                                <label for="input11" class="form-label">Short Description</label>
                                                <textarea class="form-control" name="short_desc" id="input11" placeholder="Short Description..." rows="3"></textarea>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="description" class="form-label">Long Description</label>
                                                <x-forms.tinymce-editor name="description" />
                                            </div>



                                            <div class="col-md-12">

                                                <label for="multiImg" class="form-label">Gallery Image </label>

                                                <input type="file" name="multi_img[]" class="form-control" multiple
                                                    id="multiImg" accept="image/jpeg, image/jpg, image/gif, image/png">

                                                <div class="row mt-2" id="preview_img"></div>

                                            </div>

                                            <div class="col-md-6">
                                                <label for="input7" class="form-label">Bed Style</label>
                                                <select id="input7" class="form-select" name="bed_style">
                                                    <option value="">Choose...</option>
                                                    <option value="queen">Queen Bed</option>
                                                    <option value="twin">Twin Bed</option>
                                                    <option value="king">King Bed</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="input7" class="form-label">Room View</label>
                                                <select id="input7" class="form-select" name="view">
                                                    <option value="">Choose...</option>
                                                    <option value="see">Sea View</option>
                                                    <option value="hill">Hill View</option>
                                                </select>
                                            </div>

                                            <!-- -->
                                            <div class="col-md-4">
                                                <label for="price" class="form-label">Room Price</label>
                                                <input type="number" name="price_per_night" class="form-control"
                                                    id="price" placeholder="Room Price">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="discount" class="form-label">Discount %</label>
                                                <input type="number" class="form-control" id="discount"
                                                    name="discount" placeholder="discount %">
                                            </div>
                                            <!-- -->
                                            <div class="col-md-4">
                                                <label for="size" class="form-label">Size</label>
                                                <input type="text" name="size" class="form-control" id="size"
                                                    placeholder="size">
                                            </div>



                                            <div class="col-md-12">
                                                <label for="facilities" class="form-label">Facilities</label>

                                                <div id="facilities">
                                                    @foreach ($facilities as $facility)
                                                        <div class="form-check form-check-info">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="facilities[]" value="{{ $facility->id }}"
                                                                id="facility{{ $facility->id }}">

                                                            <label class="form-check-label"
                                                                for="facility{{ $facility->id }}">
                                                                {{ $facility->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>



                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="roomimages" role="tabpanel">
                                <!-- -->
                            </div>

                            <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                                <!-- -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#multiImg').on('change', function() { //on file input change
                if (window.File && window.FileReader && window.FileList && window
                    .Blob) //check File API supported browser
                {
                    var data = $(this)[0].files; //this file data

                    $.each(data, function(index, file) { //loop though each file
                        if (/(\.|\/)(gif|jpe?g|png)$/i.test(file
                                .type)) { //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file) { //trigger function on successful read
                                return function(e) {
                                    var img = $('<img/>').addClass('thumb').attr('src',
                                            e.target.result).width(100)
                                        .height(80); //create image element
                                    $('#preview_img').append(
                                        img); //append image to output element
                                };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });

                } else {
                    alert("Your browser doesn't support File API!"); //if File API is absent
                }
            });
        });
    </script>
    <x-head.tinymce-config />

    <x-head.imagepreview-config />
@endpush
