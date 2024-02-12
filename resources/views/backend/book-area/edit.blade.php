@extends('backend.layouts.master')

@section('page-title', 'Book Area')

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
            <div class="breadcrumb-title pe-3">Book Area</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Book Area</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group gap-2">
                    <a href="{{ route('admin.bookarea.index') }}" class="btn btn-success ">
                        <i class='bx bx-arrow-back bx-fade-left-hover'></i>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <!--end breadcrumb-->
        <div class="row">
            <div class="page-content">
                <div class="container">
                    <div class="main-body">
                        <div class="row">
                            <div class="col-lg-9">

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title pt-1">New book Area</h5>
                                    </div>

                                    <form method="POST" action="{{ route('admin.bookarea.update', $bookarea->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="card-body">
                                            <!-- Image -->
                                            <div class="row mb-3">
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

                                            <!-- Title -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Title <span class="required text-danger">*</span>
                                                    </h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input id="name" name="title" type="text"
                                                        @class(['form-control', 'is-invalid' => $errors->has('title')])
                                                        value="{{ old('title', $bookarea->title) }}" />
                                                    @error('title')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <!-- short_title -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Short Title <span
                                                            class="required text-danger">*</span></h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input id="name" name="short_title" type="text"
                                                        @class(['form-control', 'is-invalid' => $errors->has('short_title')])
                                                        value="{{ old('short_title', $bookarea->short_title) }}" />
                                                    @error('short_title')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Description -->

                                            <div class="row mb-3">

                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Decription
                                                        <span class="required text-danger">*</span>
                                                    </h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <textarea @class(['form-control', 'is-invalid' => $errors->has('description')]) name="description" rows="3" placeholder="Address">{{ $bookarea->description }}</textarea>
                                                    @error('description')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Link URL -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Link URL</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="url" @class(['form-control', 'is-invalid' => $errors->has('link')])
                                                        placeholder="https://www.hotel.com/action-link" name="link"
                                                        value="{{ old('link', $bookarea->link) }}" />

                                                    @error('link')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Status <span class="required text-danger">*</span>
                                                    </h6>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-select" id="input46" name="status">
                                                        <option value="active" @selected($bookarea->status === 'active')>Active</option>
                                                        <option value="inactive" @selected($bookarea->status === 'inactive')>Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="d-md-flex d-grid align-items-center gap-3">
                                                    <button type="submit" class="btn btn-primary px-4">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>


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
    <script src="{{ asset('backend/assets/js/jquery.uploadPreview.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "Choose File", // Default: Choose File
                label_selected: "Change File", // Default: Change File
                no_label: false // Default: false
            });
        });

        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset('storage/' . $bookarea->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
