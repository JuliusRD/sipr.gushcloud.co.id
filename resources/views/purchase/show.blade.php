@extends('layouts.index')
@section('title')
    Show Purchase Request | SIPR
@endsection
@section('header')
    <div class="page-header text-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Manajemen Purchase
                </div>
                <h2 class="page-title">
                    {{ $purchase->purchase_code ?? '' }}
                </h2>

            </div>

        </div>
    </div>
@endsection
@section('content')
    <div class="row row-deck row-cards">
        <div class="col-md-2">
            <div class="row row-cards">
                <div class="col-12">
                    <a href="{{ route('purchase.index') }}">
                        <div class="card card-sm mb-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-dark text-white avatar">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-chevron-left" width="44" height="44"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <polyline points="15 6 9 12 15 18" />
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
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-7 d-block">

            <div class="card">
                <div class="card-header">
                    <h3>Purchase Request Form</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">Request By</div>
                        <div class="col-4">: {{ $current_user->name }}</div>
                        <div class="col-2">Request Date</div>
                        <div class="col-4">: {{ $purchase->request_date }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2">Div/Dept</div>
                        <div class="col-4">: {{ $purchase->divisi->nama }}</div>
                        <div class="col-2">Due Date</div>
                        <div class="col-4">: {{ $purchase->due_date }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2">Organization</div>
                        <div class="col-4">: {{ $purchase->institusi->nama }}</div>
                        <div class="col-2">Leader</div>
                        <div class="col-4">: {{ $purchase->leader->name }}</div>
                    </div>
                    <div class="card my-3">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <td>No.</td>
                                        <td>Description</td>
                                        <td>Quantity</td>
                                        <td align="right">Unit Price</td>
                                        <td align="right">Total (Rp)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($purchase_detail as $key => $data)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $data->description ?? '' }}</td>
                                            <td>{{ $data->quantity ?? 0 }}</td>
                                            <td align="right">Rp. {{ number_format($data->unit_price) }}</td>
                                            <td align="right">Rp. {{ number_format($data->total) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="6"></td>
                                        </tr>
                                    @endforelse
                                    @if (!empty($subtotal))
                                        <tr>
                                            <td colspan="3"></td>
                                            <td align="right">Total</td>
                                            <td align="right">Rp. {{ number_format($subtotal) }} </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">Notes (Reason of Request)</div>
                        <div class="col-8">: {{ $purchase->note ?? '-' }}</div>
                    </div>
                    <div class="card my-3">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table text-center">
                                <thead>
                                    <tr>
                                        <td>Prepared</td>
                                        <td>Checker</td>
                                        <td>Approved Leader</td>
                                        <td>Approved Finance</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $current_user->name ?? '-' }}</td>
                                        <td>{{ $purchase->ga->name ?? '-' }}<br><small><i>({{ $purchase->approval->approval_ga_status }})</i></small>
                                        </td>
                                        <td>{{ $purchase->leader->name ?? '-' }}<br><small><i>({{ $purchase->approval->approval_leader_status }})</i></small>
                                        </td>
                                        <td>{{ $purchase->finance->name ?? '-' }}<br><small><i>({{ $purchase->approval->approval_finance_status }})</i></small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <p class="mb-0">
                            {!! $purchase->approval->approval_ga_status == 'Tidak Disetujui' ? 'Alasan GA Tidak Menyetujui: ' . $purchase->approval->ga_reason . '<br>' : '' !!}
                            {!! $purchase->approval->approval_leader_status == 'Tidak Disetujui' ? 'Alasan Leader Tidak Menyetujui: ' . $purchase->approval->leader_reason . '<br><br>' : '' !!}
                            {!! $purchase->approval->approval_finance_status == 'Tidak Disetujui' ? 'Alasan Finance Tidak Menyetujui: ' . $purchase->approval->finance_reason . '<br><br>' : '' !!}
                        </p>
                        <p class="mb-0">
                            Note :
                        </p>
                        <ol>
                            <li>Untuk pengajuan event internal maupun external mohon untuk melampirkan detail budget</li>
                            <li>Purchase request maksimal submit setiap hari Rabu dan pembayaran akan dijalakankan di hari
                                Jumat</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 d-block">
            <div class="card mb-3">
                <div class="card-header">
                    <h3>Report</h3>
                </div>
                <div class="card-body">

                    @if ($purchase->approval->approval_leader_status != 'Tidak Disetujui')
                        @if ($purchase->approval->approval_finance_status != 'Tidak Disetujui')
                            @if ($purchase->approval->approval_leader_status != 'Disetujui')
                                @if ($purchase->approval->approval_finance_status != 'Disetujui')
                                    <div>
                                        <a href="{{ route('purchase.edit', $purchase->id) }}"
                                            class="btn btn-info w-100 mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-pencil" width="44" height="44"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" />
                                                <line x1="13.5" y1="6.5" x2="17.5" y2="10.5" />
                                            </svg>
                                            Edit
                                        </a>
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endif

                    @if ($purchase->approval->approval_ga_status == 'Disetujui')
                        @if ($purchase->approval->approval_leader_status == 'Disetujui')
                            @if ($purchase->approval->approval_finance_status == 'Disetujui')
                                <div>
                                    <a href="{{ route('report.index', $purchase->id) }}" class="btn btn-success w-100"
                                        target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-file-text" width="44" height="44"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <line x1="9" y1="9" x2="10" y2="9" />
                                            <line x1="9" y1="13" x2="15" y2="13" />
                                            <line x1="9" y1="17" x2="15" y2="17" />
                                        </svg>
                                        Lihat Report
                                    </a>
                                </div>
                            @endif
                        @endif
                    @endif

                    @if ($purchase->approval->approval_leader_status != 'Tidak Disetujui')
                        @if ($purchase->approval->approval_finance_status != 'Tidak Disetujui')
                            @if ($purchase->approval->approval_leader_status != 'Disetujui')
                                @if ($purchase->approval->approval_finance_status != 'Disetujui')
                                    <hr class="my-3">
                                    <div>
                                        <form class="form-delete" onsubmit="return confirm('Konfirmasi hapus data ini?')"
                                            action="{{ route('purchase.destroy', $purchase->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" onclick="$(this).closest('form').submit();"
                                                class="btn btn-danger w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-trash" width="44" height="44"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <line x1="4" y1="7" x2="20" y2="7" />
                                                    <line x1="10" y1="11" x2="10" y2="17" />
                                                    <line x1="14" y1="11" x2="14" y2="17" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                                Delete
                                            </a>
                                        </form>
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
@endsection
@section('custom-js')
@endsection
