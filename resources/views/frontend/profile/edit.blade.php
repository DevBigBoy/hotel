@extends('frontend.layouts.master')

@section('page-title', 'Profile')

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
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                </form>
                                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="billing-details">
                                                <h3 class="title">Profile Information</h3>

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group">
                                                            <label> Name <span class="required">*</span>
                                                            </label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ old('name', $user->name) }}" />
                                                            @error('name')
                                                                <span
                                                                    class="text text-danger text-center">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group">
                                                            <label>Phone <span class="required">*</span></label>
                                                            <input type="text" class="form-control" name="phone"
                                                                value="{{ old('phone', $user->phone) }}" />

                                                            @error('phone')
                                                                <span
                                                                    class="text text-danger text-center">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-6">
                                                        <div class="form-group">
                                                            <label>Email Address
                                                                <span class="required">*</span></label>
                                                            <input type="email" class="form-control" name="email"
                                                                value="{{ old('email', $user->email) }}" />

                                                            @error('email')
                                                                <span
                                                                    class="text text-danger text-center">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                                            <div class="form-group">
                                                                <div class="alert alert-warning text-center">
                                                                    Your email address is unverified.<button
                                                                        form="send-verification"
                                                                        class="btn btn-link px-0 py-0 normal">
                                                                        Click here to re-send the verification email.
                                                                    </button>
                                                                </div>

                                                                @if (session('status') === 'verification-link-sent')
                                                                    <div class="alert alert-success">
                                                                        A new verification link has been sent to your email
                                                                        address.
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-lg-12 col-md-6">
                                                        <div class="form-group">
                                                            <label>User Profile
                                                                <span class="required">*</span></label>
                                                            <input type="file" class="form-control" name="photo" />
                                                            @error('photo')
                                                                <span
                                                                    class="text text-danger text-center">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-6">
                                                        <div class="form-group">
                                                            <label>Town / City
                                                                <span class="required">*</span></label>
                                                            <input type="text" class="form-control" name="address"
                                                                value="{{ old('address', $user->address) }}" />
                                                            @error('address')
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
