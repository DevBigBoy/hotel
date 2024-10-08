@extends('backend.layouts.master')

@section('page-title', 'Edit Post')

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
            <div class="breadcrumb-title pe-3">Post</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Post</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group gap-2">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-success ">
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
                            <div class="col-xl-12 mx-auto">
                                <div class="card">
                                    <div class="card-header px-4 py-3">
                                        <h5 class="mb-0">Edit Post</h5>
                                    </div>

                                    <div class="card-body p-4">
                                        <form method="POST" action="{{ route('admin.posts.update', $post->id) }}"
                                            enctype="multipart/form-data" class="row">
                                            @csrf
                                            @method('PUT')

                                            <!-- Image -->
                                            <div class="col-md-12">
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
                                            <div class="col-md-12 mt-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" @class(['form-control', 'is-invalid' => $errors->has('title')]) id="title"
                                                    value="{{ $post->title }}" name="title">

                                                @error('title')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <!-- Category Name -->
                                            <div class="col-md-6 mt-3">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select id="category_id" @class(['form-select', 'is-invalid' => $errors->has('category_id')]) name="category_id">

                                                    @foreach ($categories as $category)
                                                        <option @selected($post->category_id === $category->id) value="{{ $category->id }}">
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('category_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <!-- status -->
                                            <div class="col-md-6 mt-3">
                                                <label for="status" class="form-label">status</label>
                                                <select id="status" @class(['form-select', 'is-invalid' => $errors->has('status')]) name="status">
                                                    <option @selected($post->status === 'published') value="published">published
                                                    </option>
                                                    <option @selected($post->status === 'draft') value="draft">draft</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <!-- Post Body -->
                                            <div class="col-md-12 mt-3">
                                                <label for="body" class="form-label">Body</label>
                                                <x-forms.tinymce-editor name="body" value="{!! $post->body !!}" />
                                            </div>

                                            <div class="col-md-12 mt-4">
                                                <div class="d-md-flex d-grid align-items-center gap-3">
                                                    <button type="submit" class="btn btn-primary px-4">Save</button>
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
        </div>
        <!--end row-->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset('storage/uploads/' . $post->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>

    <x-head.tinymce-config />

    <x-head.imagepreview-config />
@endpush
