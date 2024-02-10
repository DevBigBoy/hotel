@extends('frontend.layouts.master')

@section('page-title', 'Booking Details')

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

            </div>
        </div>
    </div>
    <!-- Service Details Area End -->
@endsection
