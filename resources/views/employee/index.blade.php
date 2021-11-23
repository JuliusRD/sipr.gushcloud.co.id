@extends('layouts.index')
@section('title')
    Employee | SIPR
@endsection
@section('header')
    <div class="page-header text-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Employee Management
                </div>
                <h2 class="page-title">
                    {{ $leader_name ?? '' }} <svg xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-chevrons-right" width="44" height="44" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <polyline points="7 7 12 12 7 17" />
                        <polyline points="13 7 18 12 13 17" />
                    </svg> Employee
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">

                    <a href="{{ route('leader_employee.create', $leader_id) }}"
                        class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                        data-bs-target="#modal-report">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        New Employee
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row row-deck row-cards">
        <div class="col-md-3">
            <div class="row row-cards">
                <div class="col-12">
                    <a href="{{ route('user.index') }}">
                        <div class="card card-sm mb-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-dark text-white avatar">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-chevron-left" width="44" height="44"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <polyline points="15 6 9 12 15 18"></polyline>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Back
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="card card-sm mb-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-blue text-white avatar"><svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-users" width="44" height="44"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        {{ $total_employee ?? 0 }}
                                    </div>
                                    <div class="text-muted">
                                        Employee
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-9 d-block">
            <div class="card">
                <div class="card-header d-block d-sm-flex justify-content-between">
                    <div>
                        <h3 class="card-title">Employee Data</h3>
                    </div>
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="input-icon mt-3 mt-sm-0">
                            <input type="text" name="cari" class="form-control" placeholder="Search…"
                                {{ request('keyword') }}>
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="10" cy="10" r="7"></circle>
                                    <line x1="21" y1="21" x2="15" y2="15"></line>
                                </svg>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter">
                        <thead>
                            <tr>
                                <th width="50px">No.</th>
                                <th width="100px">Role</th>
                                <th>Name</th>
                                <th width="200px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($user as $key => $data)
                                <tr>
                                    <td class="w-1 pe-0">
                                        {{ $user->firstItem() + $key }}
                                    </td>
                                    <td>
                                        <span class="badge bg-dark-lt">{{$data->role}}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('employee.show', $data->id) }}">{{ $data->name }}</a>
                                    </td>
                                    @if ($data->role == 'Employee')
                                        <td>
                                            <a href="{{ route('employee.edit', $data->id) }}" class="btn btn-info btn-sm">
                                                Edit
                                            </a>
                                            <form class="form-delete"
                                                onsubmit="return confirm('Konfirmasi hapus data ini?')"
                                                action="{{ route('employee.destroy', $data->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="leader_id" value="{{ $data->leader_id }}">
                                                <a href="#" onclick="$(this).closest('form').submit();"
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            </form>
                                        </td>
                                    @else
                                        <td>
                                            <small class="text-muted"><i>Can't edit or delete here</i></small>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6">Data not found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                    {{ $user->links('layouts.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="#" id="form-employee">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Employee type</label>
                    <div class="form-selectgroup-boxes row mb-3">
                        <div class="col-lg-6">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="employee-type" class="form-selectgroup-input"
                                    value="{{ route('leader_employee.create', $leader_id) }}" required checked>
                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </span>
                                    <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">New</span>
                                        <span class="d-block text-muted">Input New Employee</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="employee-type"
                                    value="{{ route('leader_employee.select', $leader_id) }}"
                                    class="form-selectgroup-input">
                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </span>
                                    <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Select</span>
                                        <span class="d-block text-muted">Select from existing Leader</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right"
                            width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <polyline points="9 6 15 12 9 18" />
                        </svg>
                        Next
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    $(document).ready(function() {
        $("#form-employee").on('submit', function(e) {
            e.preventDefault();
            var data = $('input[name="employee-type"]:checked').val();
            window.location.replace(data);
        });
    })
</script>
@endsection
