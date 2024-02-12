@extends('backend.layouts.master')

@section('page-title', 'Book Area')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Book area</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">

                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Book Area</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.bookarea.create') }}" class="btn btn-primary">
                        <i class='bx bx-plus'></i>
                        New Book Area
                    </a>
                </div>
            </div>
        </div>

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-10 col-md-12 mx-auto">

                <h6 class="mb-0 text-uppercase">All Book Area</h6>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <table class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Short Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($bookareas as $book)
                                    <tr>
                                        <th scope="row">{{ $book->id }}</th>
                                        <td>
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="" height="80px">
                                        </td>

                                        <td>
                                            <a href="{{ $book->link ?? '#' }}" class="btn btn-primary">
                                                Quick Booking
                                            </a>
                                        </td>

                                        <td style="width: 240px">{{ $book->description }}</td>

                                        <td style="width: 240px">{{ $book->title }}</td>

                                        <td style="width: 240px">{{ $book->short_title }}</td>

                                        <td class="text-center lh-lg">
                                            @if ($book->status == 'active')
                                                <span class="badge text-bg-primary p-2 fs-6 mt-2">Active</span>
                                            @else
                                                <span class="badge text-bg-danger p-2 fs-6 mt-2">Inactive</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.bookarea.edit', $book->id) }}"
                                                class="btn btn-primary d-inline-block ">
                                                <i class='bx bx-edit'></i>
                                                edit
                                            </a>

                                            <a href="{{ route('admin.bookarea.show', $book->id) }}"
                                                class="btn btn-warning d-inline-block mx-2">
                                                <i class='bx bxs-show'></i> View
                                            </a>

                                            <form action="{{ route('admin.bookarea.destroy', $book->id) }}" method="post"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.bookarea.destroy', $book->id) }}"
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
