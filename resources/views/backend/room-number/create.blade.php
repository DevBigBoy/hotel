@extends('backend.layouts.master')

@section('page-title', 'Room Number')



@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Room Number</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Room Number</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group gap-2">
                    <a href="{{ route('admin.room-numbers.index') }}" class="btn btn-success ">
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
                                        <h5 class="card-title pt-1">New Room Number</h5>
                                    </div>

                                    <form method="POST" action="{{ route('admin.room-numbers.store') }}">
                                        @csrf

                                        <div class="card-body">

                                            <!-- Title -->
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Room Number <span
                                                            class="required text-danger">*</span>
                                                    </h6>
                                                </div>

                                                <div class="col-sm-9 text-secondary">
                                                    <input id="name" name="room_number" type="text"
                                                        @class(['form-control', 'is-invalid' => $errors->has('room_number')]) value="{{ old('room_number') }}" />
                                                    @error('room_number')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">
                                                        Room
                                                        <span class="required text-danger">*</span>
                                                    </h6>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-select" name="room_id">
                                                        <option value="">Select Room</option>
                                                        @foreach ($rooms as $room)
                                                            <option value="{{ $room->id }}">
                                                                Room ID: {{ $room->id }} - {{ $room->roomType->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    @error('status')
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
                                                        <option value="">Select Status</option>
                                                        <option value="available">available</option>
                                                        <option value="occupied">occupied</option>
                                                        <option value="maintenance">maintenance</option>
                                                    </select>
                                                    @error('status')
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="d-md-flex d-grid align-items-center gap-3">
                                                    <button type="submit" class="btn btn-primary px-4">Save</button>
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
