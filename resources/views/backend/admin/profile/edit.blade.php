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
            <div class="breadcrumb-title pe-3">User Profile</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="container">
            <div class="main-body">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ asset('storage/' . $admin->photo) }}" class="rounded-circle p-1 bg-primary"
                                        width="120px" height="120px">

                                    <div class="mt-3">
                                        <h4>{{ $admin->name }}</h4>
                                        <p class="text-secondary mb-1">{{ $admin->address }}</p>
                                        <p class="text-muted font-size-sm">{{ $admin->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title pt-1">Profile Information</h5>
                            </div>

                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                <div class="card-body">

                                    <div class="row mb-3">
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">
                                                <i class='bx bx-image-add bx-lg bx-tada-hover'></i>
                                            </label>
                                            <input type="file" name="photo" id="image-upload" />
                                        </div>

                                        @error('photo')
                                            <span class="text text-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="name" name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')])
                                                value="{{ old('name', $admin->name) }}" />
                                            @error('name')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="email" name="email" type="email" @class(['form-control', 'is-invalid' => $errors->has('email')])
                                                value="{{ old('email', $admin->email) }}" />

                                            @error('email')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        @if ($admin instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$admin->hasVerifiedEmail())
                                            <div>
                                                <div class="alert alert-warning text-center">
                                                    Your email address is unverified.<button form="send-verification"
                                                        class="btn btn-link px-0 py-0 normal">
                                                        Click here to re-send the verification email.
                                                    </button>
                                                </div>

                                                @if (session('status') === 'verification-link-sent')
                                                    <div class="alert alert-success">
                                                        A new verification link has been sent to your email address.
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="phone" @class(['form-control', 'is-invalid' => $errors->has('phone')])
                                                value="{{ old('phone', $admin->phone) }}" />
                                            @error('phone')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="address" @class(['form-control', 'is-invalid' => $errors->has('address')])
                                                value="{{ old('address', $admin->address) }}" />
                                            @error('address')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
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
                'background-image': 'url({{ asset('storage/' . $admin->photo) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
