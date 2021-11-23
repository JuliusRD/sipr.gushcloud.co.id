@extends('layouts.index')
@section('title')
    Purchase Request Detail | SIPR
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
                    Purchase Request Detail
                </h2>
            </div>

        </div>
    </div>
@endsection
@section('content')
    <div class="row row-deck row-cards">
        <div class="col-md-3 d-block">
            <div class="row row-cards">                
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">{{$purchase->purchase_code ?? ''}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">Request By</div>
                                <div class="col-7">: {{$current_user->name}}</div>
                                <div class="col-5">Divisi/Dept</div>
                                <div class="col-7">: {{$purchase->divisi->nama ?? ''}}</div>
                                <div class="col-5">Request Date</div>
                                <div class="col-7">: {{$purchase->request_date}}</div>                           
                                <div class="col-5">Due Date</div>
                                <div class="col-7">: {{$purchase->due_date}}</div>
                                <div class="col-5">Organization</div>
                                <div class="col-7">: {{$purchase->institusi->nama}}</div>
                                <div class="col-5">GA/Checker</div>
                                <div class="col-7">: {{$purchase->ga->name}}</div>
                                <div class="col-5">Leader</div>
                                <div class="col-7">: {{$purchase->leader->name}}</div>
                                <div class="col-5">Finance</div>
                                <div class="col-7">: {{$purchase->finance->name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-12">Notes (Reason of Request) :</div>
                                <div class="col-12">{{$purchase->note ?? '-'}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-9 d-block">
            <div class="card">
                <ul class="nav nav-tabs " data-bs-toggle="tabs">
                    <li class="nav-item">
                        <a href="#tabs-home-17" class="nav-link disabled" data-bs-toggle="tab">
                            <h3 class="card-title my-2">Step 1: Purchase Request</h3>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#tabs-profile-17" class="nav-link active" data-bs-toggle="tab">
                            <h3 class="card-title text-dark my-2">Step 2: Detail</h3>
                        </a>
                    </li>

                </ul>
                <div class="card-body">
                    <a href="#" class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modal-report">+
                        Input
                        Detail</a>
                    <div class="card">
                        
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th align="right">Unit Price</th>
                                        <th align="right">Total</th>
                                        <th width="150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($purchase_detail as $key => $data)
                                        <tr>
                                            <td>{{ $purchase_detail->firstItem() + $key }}</td>
                                            <td>
                                                {{ $data->description ?? '' }}
                                            </td>
                                            <td>{{ $data->quantity ?? 0 }}</td>
                                            <td align="right">Rp. {{ number_format($data->unit_price) }}</td>
                                            <td align="right">Rp. {{ number_format($data->total) }}</td>
                                            <td>
                                                <a href="javascript:;" class="btn btn-info btn-sm editModalBtn"
                                                    data-id="{{ $data->id }}"
                                                    data-url="{{ route('purchase-detail.edit', $data->id) }}">Edit</a>
                                                <form class="form-delete"
                                                    onsubmit="return confirm('Konfirmasi hapus data ini?')"
                                                    action="{{ route('purchase-detail.destroy', $data->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="url_back" value="{{ route('purchase.detail', $purchase->id) }}">
                                                    <a href="#" onclick="$(this).closest('form').submit();"
                                                        class="btn btn-danger btn-sm">Hapus</a>
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
                    </div>

                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <form method="POST" action="{{route('history.store')}}">
                        @csrf
                        <input type="hidden" name="purchase_id" value="{{$purchase->id}}">
                        <input type="hidden" name="status" value="membuat">
                        @if(!$purchase_detail->isEmpty())
                        <button type="submit" href="" class="btn btn-success w-100">Selesai</button>
                        @else
                        <button type="button" href="" class="btn btn-success w-100" disabled>Input Detail Dahulu</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('custom-js')
<script>
    $(document).ready(function() {
        $('.editModalBtn').click(function() {
            var id = $(this).data('id');
            var action = $(this).attr("data-url");

            $.ajax({
                type: 'get',
                url: action,
                data: {
                    'id': id
                },
                async: true,
                dataType: "json",
                success: function(data) {
                    $('#form_update_purchase').attr('action', data.url_update);
                    $('#description_id').val(data.data.description);
                    $('#quantity_id').val(data.data.quantity);
                    $('#unit_price_id').val(Number(data.data.unit_price));
                    $('#modal-edit').modal('show');
                }
            });
        });
    });
    $("a.nav-link").removeAttr("href");
</script>
@endsection
@section('modal')
<div class=" modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('purchase-detail.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="description" placeholder="Description" required>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" placeholder="Quantity" required min="1" oninput="this.value = 
                            !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null">
                        </div>
                        <div class="col-lg-8">
                            <label class="form-label">Unit Price</label>
                            <input type="number" class="form-control" name="unit_price" placeholder="Unit Price"
                                required min="1" oninput="this.value = 
                                !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="purchase_id" value="{{ $id }}">
                <input type="hidden" name="url_back" value="{{ route('purchase.detail', $purchase->id) }}">
                <div class="modal-footer">
                    <a href="#" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy"
                            width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                            <circle cx="12" cy="14" r="2" />
                            <polyline points="14 4 14 8 8 8 8 4" />
                        </svg>
                        Save
                        </a>
                </div>
            </div>
        </form>
    </div>
</div>
<div class=" modal modal-blur fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="POST" id="form_update_purchase">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input id="description_id" type="text" class="form-control" name="description"
                            placeholder="Description" required>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="form-label">Quantity</label>
                            <input id="quantity_id" type="number" class="form-control" name="quantity"
                                placeholder="Quantity" required min="1" oninput="this.value = 
                                !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null">
                        </div>
                        <div class="col-lg-8">
                            <label class="form-label">Unit Price</label>
                            <input id="unit_price_id" type="number" class="form-control" name="unit_price"
                                placeholder="Unit Price" required min="1" oninput="this.value = 
                                !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="url_back" value="{{ route('purchase.detail', $purchase->id) }}">
                <div class="modal-footer">
                    <a href="#" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy"
                            width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                            <circle cx="12" cy="14" r="2" />
                            <polyline points="14 4 14 8 8 8 8 4" />
                        </svg>
                        Save
                        </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
