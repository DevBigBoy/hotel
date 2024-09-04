@extends('backend.layouts.master')

@push('styles')
    <style type="text/css">
        #image-preview {
            width: 160px;
            height: 160px;
            position: relative;
            overflow: hidden;
            background-color: #e2e2e2;
            color: #fff;
            box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
            margin: 0.5rem auto;
            border-radius: 50%;
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
            <div class="breadcrumb-title pe-3">Team</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Team</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group gap-2">
                    <a href="{{ route('admin.teams.index') }}" class="btn btn-success ">
                        <i class='bx bx-arrow-back bx-fade-left-hover'></i>
                        Back
                    </a>

                    <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">
                        <i class='bx bx-plus'></i>
                        Add Team Memeber
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
                                        <h5 class="card-title pt-1">Add Team</h5>
                                    </div>

                                    <form method="POST" action="{{ route('admin.teams.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="card-body">
                                            <!-- Image -->
                                            <div class="row mb-3">
                                                <div id="image-preview" class="image-preview">
                                                    <label for="image-upload" id="image-label">
                                                        <i class='bx bx-image-add bx-lg bx-tada-hover'></i>
                                                    </label>
                                                    <input type="file" name="image" id="image-upload" />
                                                </div>

                                                @error('photo')
                                                    <span class="text text-danger text-center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Name -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Name <span class="required text-danger">*</span></h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input id="name" name="name" type="text"
                                                        @class(['form-control', 'is-invalid' => $errors->has('name')]) value="{{ old('name') }}" />
                                                    @error('name')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Position -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Postion <span class="required text-danger">*</span>
                                                    </h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input name="postion" type="text" @class(['form-control', 'is-invalid' => $errors->has('postion')])
                                                        value="{{ old('postion') }}" />
                                                    @error('postion')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Facebook URL -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Facebook URL</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="url" name="facebook_url" @class(['form-control', 'is-invalid' => $errors->has('facebook_url')])
                                                        placeholder="https://www.facebook.com/your-username"
                                                        value="{{ old('facebook_url') }}" />
                                                    @error('facebook_url')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Twitter URL -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Twitter URL</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="url" name="twitter_url" @class(['form-control', 'is-invalid' => $errors->has('twitter_url')])
                                                        placeholder="https://www.twitter.com/your-username"
                                                        value="{{ old('twitter_url') }}" />
                                                    @error('twitter_url')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- LinkedIn URL -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">LinkedIn URL</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input name="linkedin_url" type="url" @class(['form-control', 'is-invalid' => $errors->has('linkedin_url')])
                                                        placeholder="https://www.linkedin.com/in/your-username"
                                                        value="{{ old('linkedin_url') }}" />
                                                    @error('linkedin_url')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Instagram URL -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Instagram URL</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="url" class="form-control"
                                                        placeholder="https://www.instagram.com/your-username"
                                                        name="instagram_url" @class([
                                                            'form-control',
                                                            'is-invalid' => $errors->has('instagram_url'),
                                                        ])
                                                        value="{{ old('instagram_url') }}" />

                                                    @error('instagram_url')
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
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="d-md-flex d-grid align-items-center gap-3">
                                                    <button type="submit" class="btn btn-primary px-4">Submit</button>
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
    </script>
@endpush
