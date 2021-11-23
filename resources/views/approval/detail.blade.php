@extends('layouts.index')
@section('custom-css')
    @if (Auth::id() == $purchase->ga_id and $purchase->approval->approval_ga_status == 'Tidak Disetujui')
        <style>
            #reasondecline {
                display: block;
            }

        </style>
    @elseif(Auth::id() == $purchase->leader_id and $purchase->approval->approval_leader_status == 'Tidak Disetujui')
        <style>
            #reasondecline {
                display: block;
            }

        </style>
    @elseif(Auth::id() == $purchase->finance_id and $purchase->approval->approval_finance_status == 'Tidak Disetujui')
        <style>
            #reasondecline {
                display: block;
            }

        </style>
    @else
        <style>
            #reasondecline {
                display: none;
            }

        </style>
    @endif
@endsection
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
                    @if (Auth::User()->role == 'Leader' or Auth::User()->email == 'hari.apri@gushcloud.com')
                        <a href="{{ route('approval.index') }}">
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
                    @else
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
                    @endif
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
                                        <td>
                                            {{ $purchase->ga->name ?? '-' }}<br>
                                            <small>
                                                <i>
                                                    ({{ $purchase->approval->approval_ga_status }})

                                                </i>
                                            </small>
                                        </td>
                                        <td>
                                            {{ $purchase->leader->name ?? '-' }}<br>
                                            <small>
                                                <i>
                                                    ({{ $purchase->approval->approval_leader_status }})

                                                </i>
                                            </small>
                                        </td>
                                        <td>
                                            {{ $purchase->finance->name ?? '-' }}<br>
                                            <small>
                                                <i>
                                                    ({{ $purchase->approval->approval_finance_status }})

                                                </i>
                                            </small>
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
            @if ($purchase->ga_id == Auth::id() or $purchase->leader_id == Auth::id() or $purchase->finance_id == Auth::id())
                <div class="card mb-3">
                    <div class="card-header d-block">
                        <h3>Approval</h3>
                    </div>
                    <div class="card-body">
                        @if ($purchase->ga_id == Auth::id() or $purchase->approval->approval_ga_status == 'Disetujui')
                            <form action="{{ route('approval.update', $purchase->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 ">
                                    <div class="mb-3">

                                        @if ($purchase->ga_id == Auth::id())
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="persetujuan"
                                                    value="Menunggu Persetujuan"
                                                    {{ $purchase->approval->approval_ga_status == 'Menunggu Persetujuan' ? 'checked' : '' }}>
                                                <span class="form-check-label">Menunggu Persetujuan</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="persetujuan"
                                                    value="Disetujui"
                                                    {{ $purchase->approval->approval_ga_status == 'Disetujui' ? 'checked' : '' }}>
                                                <span class="form-check-label">Disetujui</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="persetujuan"
                                                    value="Tidak Disetujui"
                                                    {{ $purchase->approval->approval_ga_status == 'Tidak Disetujui' ? 'checked' : '' }}>
                                                <span class="form-check-label">Tidak Disetujui</span>
                                            </label>
                                        @elseif($purchase->leader_id == Auth::id())
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="persetujuan"
                                                    value="Menunggu Persetujuan"
                                                    {{ $purchase->approval->approval_leader_status == 'Menunggu Persetujuan' ? 'checked' : '' }}>
                                                <span class="form-check-label">Menunggu Persetujuan</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="persetujuan"
                                                    value="Disetujui"
                                                    {{ $purchase->approval->approval_leader_status == 'Disetujui' ? 'checked' : '' }}>
                                                <span class="form-check-label">Disetujui</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="persetujuan"
                                                    value="Tidak Disetujui"
                                                    {{ $purchase->approval->approval_leader_status == 'Tidak Disetujui' ? 'checked' : '' }}>
                                                <span class="form-check-label">Tidak Disetujui</span>
                                            </label>
                                        @elseif($purchase->finance_id == Auth::id())
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="persetujuan"
                                                    value="Menunggu Persetujuan"
                                                    {{ $purchase->approval->approval_finance_status == 'Menunggu Persetujuan' ? 'checked' : '' }}>
                                                <span class="form-check-label">Menunggu Persetujuan</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="persetujuan"
                                                    value="Disetujui"
                                                    {{ $purchase->approval->approval_finance_status == 'Disetujui' ? 'checked' : '' }}>
                                                <span class="form-check-label">Disetujui</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" name="persetujuan"
                                                    value="Tidak Disetujui"
                                                    {{ $purchase->approval->approval_finance_status == 'Tidak Disetujui' ? 'checked' : '' }}>
                                                <span class="form-check-label">Tidak Disetujui</span>
                                            </label>
                                        @else

                                        @endif


                                        <div id="reasondecline">
                                            <hr class="my-2">
                                            <label class="form-label">Alasan Tidak Disetujui</label>
                                            <textarea class="form-control" name="alasan_tidak_disetujui" rows="6"
                                                placeholder="Berikan alasan ...">@if (Auth::id() == $purchase->ga_id){{ $purchase->approval->ga_reason }}@elseif(Auth::id() == $purchase->leader_id){{ $purchase->approval->leader_reason }}@elseif(Auth::id() == $purchase->finance_id){{ $purchase->approval->finance_reason }}@else @endif</textarea>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            @if($purchase->approval->approval_ga_status == 'Tidak Disetujui')
                            GA/Checker tidak menyetujui PO ini
                            @else
                            Menunggu Persetujuan GA/Checker
                            @endif
                        @endif
                    </div>
                </div>
            @endif
            @if ($purchase->approval->approval_leader_status == 'Disetujui' and $purchase->approval->approval_finance_status == 'Disetujui')
                <div class="card mb-3">
                    <div class="card-header">
                        <h3>Report</h3>
                    </div>
                    <div class="card-body">

                        <div>
                            <a href="{{ route('report.index', $purchase->id) }}" class="btn btn-success w-100"
                                target="_blank">Lihat
                                Report</a>
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>
    </div>
@endsection
@section('custom-js')
    <script>
        $(document).ready(function() {
            $('input:radio[name="persetujuan"]').change(function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 'Tidak Disetujui') {
                        $('#reasondecline').show();
                    } else {
                        $('#reasondecline').hide();
                    }
                }
            });
        });
    </script>
@endsection
