@extends('layouts.index')
@section('title')
    Approval | SIPR
@endsection
@section('header')
    <div class="page-header text-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Manajemen Approval
                </div>
                <h2 class="page-title">
                    Approval Reimbursement
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('historyreimbursement.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-history" width="44"
                            height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <polyline points="12 8 12 12 14 14" />
                            <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
                        </svg>
                        History
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row row-deck row-cards">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header d-block d-sm-flex justify-content-between">
                    <div>
                        <h3 class="card-title">Purchase Request</h3>
                        <span class="badge bg-blue-lt">Disetujui</span>
                        <span class="badge bg-yellow-lt">Menunggu Persetujuan</span>
                        <span class="badge bg-red-lt">Tidak Disetujui</span>
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
                                <th width="10px">No.</th>
                                <th width="130px">Approval Leader</th>                                
                                <th width="100px">Reimbursement Code</th>
                                <th width="130px">Name</th>
                                <th width="250px">Request Date</th>
                                <th width="130px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reimbursement as $key => $data)
                                <tr>
                                    <td class="w-1 pe-0">
                                        {{ $reimbursement->firstItem() + $key }}
                                    </td>
                                    <td>
                                        @if (!empty($data->approval->approval_leader_status))
                                            @switch($data->approval->approval_leader_status)
                                                @case($data->approval->approval_leader_status == 'Menunggu Persetujuan')
                                                    <span class="badge bg-yellow-lt"><small>Menunggu Persetujuan</small></span>
                                                @break
                                                @case($data->approval->approval_leader_status == 'Tidak Disetujui')
                                                    <span class="badge bg-red-lt"><small>Tidak Disetujui</small></span>
                                                @break
                                                @case($data->approval->approval_leader_status == 'Disetujui')
                                                    <span class="badge bg-blue-lt"><small>Disetujui</small></span>
                                                @break
                                                @default
                                                    <span class="badge bg-yellow-lt"><small>Menunggu Persetujuan</small></span>
                                            @endswitch
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $data->reimbursement_code ?? '' }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $data->request->name ?? '' }}</small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $data->request_date }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('approvalreimbursement.show', $data->id) }}" class="btn btn-primary btn-sm">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data not found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center">
                        {{ $reimbursement->links('layouts.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
