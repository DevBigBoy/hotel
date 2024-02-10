@extends('frontend.layouts.master')

@section('page-title', 'change password')

@section('content')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg6">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>User Dashboard</li>
                </ul>
                <h3>User Dashboard</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Service Details Area -->
    <div class="service-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.profile.partials.user-sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="service-article">
                        <section class="checkout-area pb-70">
                            <div class="container">
                                <form method="post" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="billing-details">
                                                <h3 class="title">Update Password</h3>

                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="update_password_current_password">
                                                                Current Password
                                                                <span class="required">*</span></label>
                                                            </label>
                                                            <input id="update_password_current_password"
                                                                name="current_password" type="password"
                                                                @class([
                                                                    'form-control',
                                                                    'is-invalid' => $errors->getBag('updatePassword')->first('current_password'),
                                                                ]) />

                                                            @error('current_password', 'updatePassword')
                                                                <span class="text text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="update_password_password">New Password
                                                                <span class="required">*</span></label>
                                                            <input id="update_password_password" name="password"
                                                                type="password" @class([
                                                                    'form-control',
                                                                    'is-invalid' => $errors->getBag('updatePassword')->first('password'),
                                                                ]) />
                                                            @error('password', 'updatePassword')
                                                                <span class="text text-danger">{{ $message }}</span>
                                                            @enderror

                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="update_password_password_confirmation">Confirm
                                                                Password
                                                                <span class="required">*</span></label>
                                                            <input id="update_password_password_confirmation"
                                                                name="password_confirmation" type="password"
                                                                @class([
                                                                    'form-control',
                                                                    'is-invalid' => $errors->getBag('updatePassword')->first('password_confirmation'),
                                                                ]) />
                                                            @error('password_confirmation', 'updatePassword')
                                                                <span class="text text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <button type="submit" class="btn btn-danger">
                                                        Save Changes
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service Details Area End -->
@endsection
