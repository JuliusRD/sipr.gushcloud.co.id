@extends('layouts.index')
@section('title')
Organization | SIPR
@endsection
@section('header')
    <div class="page-header text-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Organization Management
                </div>
                <h2 class="page-title">
                    Organization
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('institusi.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        New Organization
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
                    <div class="card card-sm mb-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-blue text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-building" width="44" height="44"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="3" y1="21" x2="21" y2="21"></line>
                                            <line x1="9" y1="8" x2="10" y2="8"></line>
                                            <line x1="9" y1="12" x2="10" y2="12"></line>
                                            <line x1="9" y1="16" x2="10" y2="16"></line>
                                            <line x1="14" y1="8" x2="15" y2="8"></line>
                                            <line x1="14" y1="12" x2="15" y2="12"></line>
                                            <line x1="14" y1="16" x2="15" y2="16"></line>
                                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        {{ $total_institusi }}
                                    </div>
                                    <div class="text-muted">
                                        Organization Total
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-9">
            <div class="card">
                <div class="card-header d-block d-sm-flex justify-content-between">
                    <div>
                        <h3 class="card-title">Organization Data</h3>
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
                                <th>No.</th>
                                <th width="150px">Organization Name</th>
                                <th>Division</th>
                                <th width="200px">Created At</th>
                                <th width="250px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($institusi as $key => $data)
                                <tr>
                                    <td class="w-1 pe-0">
                                        {{ $institusi->firstItem() + $key }}
                                    </td>
                                    <td>
                                        {{ $data->nama }}
                                    </td>
                                    <td>
                                        @forelse ($data->divisi->sortBy('nama') as $divisi)
                                        <span class="badge bg-blue-lt"><small>{{ $divisi->nama }}</small></span>
                                        @empty
                                        <small><i>Division doesn't exist</i></small>
                                        @endforelse
                                    </td>
                                    <td>
                                        {{ $data->created_at }}
                                    </td>
                                    <td>
                                        <a href="{{ route('institusi_divisi.index', $data->id) }}" class="btn btn-success btn-sm">
                                            Division
                                        </a>
                                        <a href="{{ route('institusi.edit', $data->id) }}" class="btn btn-info btn-sm">
                                            Edit
                                        </a>
                                        <form class="form-delete" onsubmit="return confirm('Konfirmasi hapus data ini?')"
                                            action="{{ route('institusi.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" onclick="$(this).closest('form').submit();"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="4">Data not found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                    {{ $institusi->links('layouts.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
