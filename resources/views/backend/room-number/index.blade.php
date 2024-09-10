@extends('backend.layouts.master')

@section('page-title', 'Room Number')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Room Number</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Room Number</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group">
                    @if ($rooms)
                        <a href="{{ route('admin.room-numbers.create') }}" class="btn btn-primary">
                            <i class='bx bx-plus'></i>
                            New Room Number
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-10 col-md-10 mx-auto mt-3">
                <h6 class="mb-0 text-uppercase">All Room Numbers</h6>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <table class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Room Number</th>
                                    <th scope="col">Room Type</th>
                                    <th scope="col">Total Adults</th>
                                    <th scope="col">Total Children</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($room_numbers as $room_number)
                                    <tr>
                                        <th scope="row">{{ $room_number->id }}</th>

                                        <td>{{ $room_number->room_number }}</td>

                                        <td>{{ $room_number->room->roomType->name ?? 'N/A' }}</td>

                                        <td>{{ $room_number->room->total_adults ?? 'N/A' }}</td>

                                        <td>{{ $room_number->room->total_children ?? 'N/A' }}</td>

                                        <td class="text-center lh-lg">

                                            @if ($room_number->status == 'available')
                                                <span class="badge text-bg-success p-2 fs-6 mt-2">Available</span>
                                            @elseif ($room_number->status == 'occupied')
                                                <span class="badge text-bg-warning p-2 fs-6 mt-2">Occupied</span>
                                            @else
                                                <span class="badge text-bg-danger p-2 fs-6 mt-2">Maintenance</span>
                                            @endif

                                        </td>

                                        <td>
                                            <a href="{{ route('admin.room-numbers.edit', $room_number->id) }}"
                                                class="btn btn-primary d-inline-block ">
                                                <i class='bx bx-edit'></i>
                                                edit
                                            </a>

                                            <form action="{{ route('admin.room-numbers.destroy', $room_number->id) }}"
                                                method="post" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.room-numbers.destroy', $room_number->id) }}"
                                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                                    class="btn btn-danger">
                                                    <i class='bx bx-trash'></i> delete </a>
                                            </form>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center p-2">
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
