@extends('backend.layouts.master')


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
                                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Admin"
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

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Update Password</h5>
                            </div>

                            <form method="post" action="{{ route('admin.password.update') }}">
                                @csrf
                                @method('put')
                                <div class="card-body">

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 pt-1">Current Password</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="update_password_current_password" name="current_password"
                                                type="password" @class([
                                                    'form-control',
                                                    'is-invalid' => $errors->getBag('updatePassword')->first('current_password'),
                                                ])
                                                autocomplete="current-password" />

                                            @error('current_password', 'updatePassword')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">New Password</h6>
                                        </div>

                                        <div class="col-sm-9 text-secondary">
                                            <input id="update_password_password" name="password" type="password"
                                                @class([
                                                    'form-control',
                                                    'is-invalid' => $errors->getBag('updatePassword')->first('password'),
                                                ]) />

                                            @error('password', 'updatePassword')
                                                <span class="text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Confirm Password</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input id="update_password_password_confirmation" name="password_confirmation"
                                                type="password" @class([
                                                    'form-control',
                                                    'is-invalid' => $errors->getBag('updatePassword')->first('password_confirmation'),
                                                ]) />

                                            @error('password_confirmation', 'updatePassword')
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
