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
                <h6 class="mb-0 text-uppercase">Room Info</h6>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab"
                                    aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon">
                                            <i class="bx bx-home font-18 me-1"></i>
                                        </div>
                                        <div class="tab-title">Basic</div>
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
                                                    <option value="">Choose...</option>
                                                    @foreach ($room_types as $room_type)
                                                        <option value="{{ $room_type->id }}">{{ $room_type->name }}</option>
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
                                                    <option value="">Choose...</option>
                                                    <option value="available">available</option>
                                                    <option value="archived">archived</option>
                                                </select>
                                                @error('status')
                                                    <span class="text text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!--Capacity -->
                                            <div class="col-md-4">
                                                <label for="room_capacity" class="form-label">Room Capacity</label>
                                                <input type="number" class="form-control" name="capacity"
                                                    id="room_capacity" placeholder="Room Capacity">
                                                @error('capacity')
                                                    <span class="text text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="total_adults" class="form-label">Total Adult</label>
                                                <input type="number" name="total_adults" class="form-control"
                                                    id="total_adults" placeholder="Total Adult">
                                                @error('total_adults')
                                                    <span class="text text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="total_children" class="form-label">Total Child</label>
                                                <input type="number" name="total_children" class="form-control"
                                                    id="total_children" placeholder="Total Child">
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
                                                <textarea class="form-control" name="short_desc" id="short_desc" placeholder="Short Description..." rows="3"></textarea>
                                                @error('short_desc')
                                                    <span class="text text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <label for="description" class="form-label">Long Description</label>
                                                <x-forms.tinymce-editor name="description" />
                                                @error('description')
                                                    <span class="text text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="bed_type" class="form-label">
                                                    Bed Style <span class="required text-danger">*</span>
                                                </label>
                                                <input type="text" name="bed_type" class="form-control"
                                                    id="total_adults" placeholder="bed type">
                                                @error('bed_type')
                                                    <span class="text text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="view_type" class="form-label">
                                                    Room View <span class="required text-danger">*</span>
                                                </label>
                                                <input type="text" name="view_type" class="form-control"
                                                    id="view_type" placeholder="View">
                                                @error('view_type')
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
                                                ])
                                                    id="price" placeholder="Room Price">
                                                @error('price_per_nights')
                                                    <span class="text text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="discount" class="form-label">After Discount </label>
                                                <input type="number" @class(['form-control', 'is-invalid' => $errors->has('discount')]) id="discount"
                                                    name="discount" placeholder="discount %">

                                                @error('discount')
                                                    <span class="text text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Size -->
                                            <div class="col-md-4">
                                                <label for="size" class="form-label">
                                                    Size <span class="required text-danger">*</span>
                                                </label>
                                                <input type="text" name="room_size" @class(['form-control', 'is-invalid' => $errors->has('room_size')])
                                                    id="room_size" placeholder="room_size">

                                                @error('room_size')
                                                    <span class="text text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary px-4">Save</button>
                                            </div>
                                        </form>
                                    </div>
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
    <x-head.tinymce-config />

    <x-head.imagepreview-config />
@endpush
