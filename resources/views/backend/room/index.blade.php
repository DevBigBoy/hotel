@extends('backend.layouts.master')

@section('page-title', 'Room')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Room</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Room</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                        <i class='bx bx-plus'></i>
                        New Room
                    </a>
                </div>
            </div>
        </div>

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-12 col-md-12 mx-auto mt-3">
                <h6 class="mb-0 text-uppercase">All Room</h6>
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

                                @forelse ($rooms as $room)
                                    <tr>
                                        <th scope="row">{{ $room->id }}</th>

                                        <td>{{ $room->name }}</td>

                                        <td>{{ $room->description }}</td>

                                        <td class="text-center lh-lg">
                                            @if ($room->status == 'active')
                                                <span class="badge text-bg-primary p-2 fs-6 mt-2">Active</span>
                                            @else
                                                <span class="badge text-bg-danger p-2 fs-6 mt-2">archived</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                                class="btn btn-primary d-inline-block ">
                                                <i class='bx bx-edit'></i>
                                                edit
                                            </a>

                                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="post"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.rooms.destroy', $room->id) }}"
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