@extends('backend.layouts.master')

@section('page-title', 'Post')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Post</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">

                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        <i class='bx bx-plus'></i>
                        New Post
                    </a>
                </div>
            </div>
        </div>

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-10 col-md-12 mx-auto">

                <h6 class="mb-0 text-uppercase">All Post</h6>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <table class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Author Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($posts as $key=>$post)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>

                                        <td>
                                            <img src="{{ asset('storage/uploads/' . $post->image) }}" alt=""
                                                width="150px" height="100px">
                                        </td>

                                        <td max-width="250px">{{ $post->title }}</td>

                                        <td max-width="250px">{{ $post->slug }}</td>

                                        <td>{{ $post->category->name }}</td>

                                        <td>{{ $post->author->name }}</td>

                                        <td class="text-center lh-lg">
                                            @if ($post->status == 'published')
                                                <span class="badge text-bg-primary p-2 fs-6 mt-2">published</span>
                                            @else
                                                <span class="badge text-bg-danger p-2 fs-6 mt-2">draft</span>
                                            @endif
                                        </td>

                                        <td width="230px">
                                            <a href="{{ route('admin.posts.edit', $post->id) }}"
                                                class="btn btn-primary d-inline-block ">
                                                <i class='bx bx-edit'></i>
                                                edit
                                            </a>


                                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.posts.destroy', $post->id) }}"
                                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                                    class="btn btn-danger">
                                                    <i class='bx bx-trash'></i> delete </a>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center p-2">
                                            No data available in table
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
@endsection
