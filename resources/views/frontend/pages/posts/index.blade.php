@extends('frontend.layouts.master')

@section('content')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg4">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>Blog </li>
                </ul>
                <h3>Posts </h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Blog Style Area -->
    <div class="blog-style-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    @foreach ($posts as $post)
                        <div class="col-lg-12">
                            <div class="blog-card">
                                <div class="row align-items-center">
                                    <div class="col-lg-5 col-md-4 p-0">
                                        <div class="blog-img">
                                            <a href="{{ route('posts.show', $post->slug) }}">
                                                <img src="{{ asset('storage/uploads/' . $post->image) }}" alt="Images">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-7 col-md-8 p-0">
                                        <div class="blog-content">
                                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                                            <h3>
                                                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                                            </h3>
                                            <p> {!! Str::limit($post->body, 150) !!}</p>
                                            <a href="{{ route('posts.show', $post->slug) }}" class="read-btn">
                                                Read More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>

                <div class="col-lg-4">
                    <div class="side-bar-wrap">
                        <div class="search-widget">
                            <form action="{{ route('posts.index') }}" method="GET" class="search-form">
                                <input type="text" name="search" placeholder="Search Posts"
                                    value="{{ request('search') }}" class="form-control">

                                <button type="submit">
                                    <i class="bx bx-search"></i>
                                </button>

                                @if (request()->hasAny(['search', 'category']))
                                    <a href="{{ route('posts.index') }}" class="btn btn-secondary d-block mt-2">Clear</a>
                                @endif
                            </form>
                        </div>

                        <div class="services-bar-widget">
                            <h3 class="title">Blog Category</h3>
                            <div class="side-bar-categories">
                                <ul>
                                    @foreach ($categories as $category)
                                        <li>
                                            <a
                                                href="{{ route('posts.index', ['category' => $category->id]) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="side-bar-widget">
                            <h3 class="title">Recent Posts</h3>

                            @if ($recentPosts->count())
                                <div class="widget-popular-post">

                                    @foreach ($recentPosts as $relatedPost)
                                        <article class="item">
                                            <a href="{{ route('posts.show', $relatedPost->slug) }}" class="thumb">
                                                <img src="{{ asset('storage/uploads/' . $relatedPost->image) }}"
                                                    alt="" width="150px">
                                            </a>
                                            <div class="info">
                                                <h4 class="title-text">
                                                    <a href="{{ route('posts.show', $relatedPost->slug) }}">
                                                        {{ $relatedPost->title }}
                                                    </a>
                                                </h4>
                                                <ul>
                                                    <li>
                                                        <i class='bx bx-user'></i>
                                                        29K
                                                    </li>
                                                    <li>
                                                        <i class='bx bx-message-square-detail'></i>
                                                        15K
                                                    </li>
                                                </ul>
                                            </div>
                                        </article>
                                    @endforeach

                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Style Area End -->
@endsection
