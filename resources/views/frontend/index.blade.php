@extends('frontend.layouts.master')



@section('content')
    <!-- Banner Area -->
    @include('frontend.pages.banner-area')
    <!-- Banner Area End -->

    <!-- Banner Form Area -->
    @include('frontend.pages.banner-form')
    <!-- Banner Form Area End -->

    <!-- Room Area -->
    @include('frontend.pages.room')
    <!-- Room Area End -->

    <!-- Book Area Two-->
    @include('frontend.pages.book')
    <!-- Book Area Two End -->

    <!-- Services Area Three -->
    @include('frontend.pages.services')
    <!-- Services Area Three End -->

    <!-- Team Area Three -->
    @include('frontend.pages.team')
    <!-- Team Area Three End -->

    <!-- Testimonials Area Three -->
    @include('frontend.pages.testimonials')
    <!-- Testimonials Area Three End -->

    <!-- FAQ Area -->
    @include('frontend.pages.faq')
    <!-- FAQ Area End -->

    <!-- Blog Area -->
    @include('frontend.pages.blog')
    <!-- Blog Area End -->
@endsection
