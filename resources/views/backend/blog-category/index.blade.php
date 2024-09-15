@extends('backend.layouts.master')

@section('page-title', 'Blog Category')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Blog</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">

                @include('backend.blog-category.create')

            </div>
        </div>

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-10 col-md-10 mx-auto mt-3">
                <h6 class="mb-0 text-uppercase">All Categories</h6>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <table class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Category Name </th>
                                    <th>Category Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($blog_categories as $key => $category)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>

                                        <td>{{ $category->name }}</td>

                                        <td>{{ $category->slug }}</td>

                                        <td>
                                            <a href="{{ route('admin.blog_categories.edit', $category->id) }}"
                                                class="btn btn-warning px-3">
                                                <i class='bx bx-edit'></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.blog_categories.destroy', $category->id) }}"
                                                method="post" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.blog_categories.destroy', $category->id) }}"
                                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                                    class="btn btn-danger">
                                                    <i class='bx bx-trash'></i> delete </a>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center p-2">
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
