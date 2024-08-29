@extends('backend.layouts.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Tables</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Basic Table</li>
                    </ol>
                </nav>
            </div>

            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">
                        <i class='bx bx-plus'></i>
                        Add Team Memeber
                    </a>
                </div>
            </div>
        </div>

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-10 col-md-12 mx-auto">

                <h6 class="mb-0 text-uppercase">all team members</h6>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <table class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Postion</th>
                                    <th scope="col">status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($teams as $team)
                                    <tr>
                                        <th scope="row">{{ $team->created_at->format('YmdHis') }}</th>
                                        <td>
                                            <img src="{{ asset('storage/' . $team->image) }}" alt="" height="80px">
                                        </td>
                                        <td>{{ $team->name }}</td>
                                        <td style="width: 240px">{{ $team->postion }}</td>
                                        <td class="text-center lh-lg">
                                            @if ($team->status == 'active')
                                                <span class="badge text-bg-primary p-2 fs-6 mt-2">Primary</span>
                                            @else
                                                <span class="badge text-bg-danger p-2 fs-6 mt-2">Primary</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.teams.edit', $team->id) }}"
                                                class="btn btn-primary d-inline-block ">
                                                <i class='bx bx-edit'></i>
                                                edit
                                            </a>
                                            <a href="{{ route('admin.teams.show', $team->id) }}"
                                                class="btn btn-warning d-inline-block mx-2">
                                                <i class='bx bxs-show'></i> View
                                            </a>

                                            <form action="{{ route('admin.teams.destroy', $team->id) }}" method="post"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.teams.destroy', $team->id) }}"
                                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                                    class="btn btn-danger">
                                                    <i class='bx bx-trash'></i> delete </a>
                                            </form>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-2">
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
