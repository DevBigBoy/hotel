@extends('frontend.layouts.master')



@section('content')
    <!-- Banner Area -->
    @include('frontend.home.banner-area')
    <!-- Banner Area End -->

    <!-- Banner Form Area -->
    @include('frontend.home.banner-form')
    <!-- Banner Form Area End -->

    <!-- Room Area -->
    @include('frontend.home.room')
    <!-- Room Area End -->

    <!-- Book Area Two-->
    @include('frontend.home.book')
    <!-- Book Area Two End -->

    <!-- Services Area Three -->
    @include('frontend.home.services')
    <!-- Services Area Three End -->

    <!-- Team Area Three -->
    @include('frontend.home.team')
    <!-- Team Area Three End -->

    <!-- Testimonials Area Three -->
    @include('frontend.home.testimonials')
    <!-- Testimonials Area Three End -->

    <!-- FAQ Area -->
    @include('frontend.home.faq')
    <!-- FAQ Area End -->

    <!-- Blog Area -->
    @include('frontend.home.blog')
    <!-- Blog Area End -->
@endsection
