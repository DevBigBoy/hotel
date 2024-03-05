@extends('backend.layouts.master')

@section('page-title', 'Room Type')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Room Type</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Room Type</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group gap-2">
                    <a href="{{ route('admin.room-types.index') }}" class="btn btn-success ">
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
                            <div class="col-md-12">

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title pt-1">New book Area</h5>
                                    </div>

                                    <form method="POST" action="{{ route('admin.room-types.store') }}">
                                        @csrf

                                        <div class="card-body">

                                            <!-- Title -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Name <span class="required text-danger">*</span>
                                                    </h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input id="name" name="name" type="text"
                                                        @class(['form-control', 'is-invalid' => $errors->has('name')]) value="{{ old('name') }}" />
                                                    @error('name')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <!-- Description -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Description
                                                    </h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <textarea name="description" @class(['form-control', 'is-invalid' => $errors->has('description')]) id="description" placeholder="description ..." rows="6"></textarea>

                                                    @error('description')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
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
