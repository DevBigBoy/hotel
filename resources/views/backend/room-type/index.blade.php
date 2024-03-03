@extends('backend.layouts.master')

@section('page-title', 'Room Types')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Room Types</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Room Types</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.room-types.create') }}" class="btn btn-primary">
                        <i class='bx bx-plus'></i>
                        New Room Type
                    </a>
                </div>
            </div>
        </div>

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-12 mx-auto mt-3">
                <h6 class="mb-0 text-uppercase">All Room Types</h6>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <table class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($types as $type)
                                    <tr>
                                        <th scope="row">{{ $type->id }}</th>

                                        <td>{{ $type->name }}</td>

                                        <td style="width: 400px">{{ $type->description }}</td>

                                        <td class="text-center lh-lg">
                                            @if ($type->status == 'active')
                                                <span class="badge text-bg-primary p-2 fs-6 mt-2">Active</span>
                                            @else
                                                <span class="badge text-bg-danger p-2 fs-6 mt-2">Archived</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.room-types.edit', $type->id) }}"
                                                class="btn btn-primary d-inline-block ">
                                                <i class='bx bx-edit'></i>
                                                edit
                                            </a>

                                            <form action="{{ route('admin.room-types.destroy', $type->id) }}" method="post"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.room-types.destroy', $type->id) }}"
                                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                                    class="btn btn-danger">
                                                    <i class='bx bx-trash'></i> delete </a>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center p-2">
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
