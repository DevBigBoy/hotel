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
                        <li class="breadcrumb-item active" aria-current="page">Edit Room</li>
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
                                <a class="nav-link active" data-bs-toggle="tab" href="#bacis" role="tab"
                                    aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bx bx-home font-18 me-1"></i>
                                        </div>
                                        <div class="tab-title">Bacis</div>
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

                        </ul>

                        <div class="tab-content py-3">
                            <!-- basic -->
                            @include('backend.room.partials.basic')

                            <!-- room-images -->
                            @include('backend.room.partials.room-images')

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
                $('.image-preview').css({
                    'background-image': 'url({{ asset('storage/' . $room->image) }})',
                    'background-size': 'cover',
                    'background-position': 'center center'
                })
            })

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


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Check if the URL contains the fragment identifier
                if (window.location.hash) {
                    // Scroll to the element with the ID that matches the fragment
                    var element = document.querySelector(window.location.hash);
                    if (element) {
                        element.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        </script>
    @endpush
