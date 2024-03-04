@extends('backend.layouts.master')

@section('page-title', 'Facilities')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Facilities</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Facilities</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary">
                        <i class='bx bx-plus'></i>
                        New Facility
                    </a>
                </div>
            </div>
        </div>

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-10 col-md-10 mx-auto mt-3">

                <h6 class="mb-0 text-uppercase">Facilities</h6>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <table class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($facilities as $facility)
                                    <tr>
                                        <th scope="row">{{ $facility->id }}</th>

                                        <td>{{ $facility->name }}</td>

                                        <td>
                                            <a href="{{ route('admin.facilities.edit', $facility->id) }}"
                                                class="btn btn-primary d-inline-block ">
                                                <i class='bx bx-edit'></i>
                                                edit
                                            </a>
                                        </td>

                                        <td>

                                            <form action="{{ route('admin.facilities.destroy', $facility->id) }}"
                                                method="post" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.facilities.destroy', $facility->id) }}"
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
