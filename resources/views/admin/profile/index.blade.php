@extends('admin.dashboard')

@push('css')
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
                                    <img src="{{ asset(Auth::user()->photo) }}" alt="Admin"
                                        class="rounded-circle p-1 bg-primary" width="110">

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

                        <!-- Profile Information -->

                        @include('admin.profile.partials.update-profile-information')

                        <!-- Update Password -->
                        @include('admin.profile.partials.update-password')


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
                'background-image': 'url({{ asset($admin->photo) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
