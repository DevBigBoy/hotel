@if ($posts->count())
    <div class="blog-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <span class="sp-color">BLOGS</span>
                <h2>Our Latest Blogs to the Intranational Journal at a Glance</h2>
            </div>

            <div class="row pt-45">

                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item">
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <img src="{{ asset('storage/uploads/' . $post->image) }}" alt="Images">
                            </a>
                            <div class="content">
                                <ul>
                                    <li>{{ $post->created_at->format('M d, Y') }}</li>
                                    <li><i class='bx bx-user'></i>29K</li>
                                    <li><i class='bx bx-message-alt-dots'></i>15K</li>
                                </ul>
                                <h3>
                                    <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}
                                    </a>
                                </h3>
                                <p>
                                    {!! Str::limit($post->body, 150) !!}
                                </p>
                                <a href="{{ route('posts.show', $post->slug) }}" class="read-btn">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
