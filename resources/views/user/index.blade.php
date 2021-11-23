@extends('layouts.index')
@section('title')
    Leader | SIPR
@endsection
@section('header')
    <div class="page-header text-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Leader Management
                </div>
                <h2 class="page-title">
                    Leader
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('user.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        New Leader
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row row-deck row-cards">
        <div class="col-md-2">
            <div class="row row-cards">
                <div class="col-12">
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
                                        {{ $total_leader ?? 0 }}
                                    </div>
                                    <div class="text-muted">
                                        Leader
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-10 d-block">
            <div class="card">
                <div class="card-header d-block d-sm-flex justify-content-between">
                    <div>
                        <h3 class="card-title">Data Leader</h3>
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
                                <th width="350px">Employee</th>
                                <th width="220px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($user as $key => $data)
                                <tr>
                                    <td class="w-1 pe-0">
                                        {{ $user->firstItem() + $key }}
                                    </td>
                                    <td>
                                        <span class="badge bg-dark-lt">{{ $data->role }}</span>
                                    </td>
                                    <td>
                                        <a href="{{route('user.show', $data->id)}}">{{ $data->name }}</a><br>
                                        {!! !empty($data->institusi->nama) ? '<span class="badge bg-blue-lt"><small>'.$data->institusi->nama.'</small></span>':'' !!}
                                        {!! !empty($data->divisi->nama) ? '<span class="badge bg-green-lt"><small>'.$data->divisi->nama.'</small></span>':'' !!}
                                    </td>    
                                    <td>
                                        @forelse ($data->employee->sortBy('nama') as $employee)
                                        <span class="badge bg-blue-lt"><small>{{ $employee->name }}</small></span>
                                        @empty
                                        <small><i>Employee doesn't exist</i></small>
                                        @endforelse
                                    </td>                                
                                    <td>
                                        @if(!empty($data->institusi_id) and !empty($data->institusi_id))
                                        <a href="{{route('leader_employee.index', $data->id)}}" class="btn btn-success btn-sm">
                                            Employee
                                        </a>
                                        @else
                                        <a href="#!" class="btn btn-success btn-sm" disabled>
                                            Employee
                                        </a>
                                        @endif
                                        <a href="{{route('user.edit', $data->id)}}" class="btn btn-info btn-sm">
                                            Edit
                                        </a>
                                        <form class="form-delete" onsubmit="return confirm('Konfirmasi hapus data ini?')"
                                            action="{{ route('user.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" onclick="$(this).closest('form').submit();"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </form>
                                    </td>
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
