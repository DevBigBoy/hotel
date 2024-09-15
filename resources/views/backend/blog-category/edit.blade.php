@extends('backend.layouts.master')

@section('page-title', 'Category')



@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group gap-2">
                    <a href="{{ route('admin.blog_categories.index') }}" class="btn btn-success ">
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
                                        <h5 class="card-title pt-1">Edit Category</h5>
                                    </div>

                                    <form method="POST"
                                        action="{{ route('admin.blog_categories.update', $blog_category->id) }}">
                                        @csrf

                                        @method('PUT')
                                        <div class="card-body">

                                            <!-- Title -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Name <span class="required text-danger">*</span>
                                                    </h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input id="name" name="name" type="text"
                                                        @class(['form-control', 'is-invalid' => $errors->has('name')])
                                                        value="{{ old('name', $blog_category->name) }}" />
                                                    @error('name')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="d-md-flex d-grid align-items-center gap-3">
                                                    <button type="submit" class="btn btn-primary px-4">update</button>
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
