<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reimbursement Order {{ $reimbursement->reimbursement_code ?? '' }}</title>
    <style>
        @font-face {
            font-family: 'Helvetica';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        body {
            font-family: Helvetica, sans-serif;
        }

        h1 {
            font-size: 14px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        table.data-utama {
            font-size: 12.5px;
        }

        table.data-detail {
            width: 100%;
            font-size: 13.5px;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
            border: 1px solid #000;
        }

        table.data-detail thead tr th {
            border: 1px solid #000;
        }

        table.data-detail tbody {
            min-height: 500px;
        }

        table.data-detail tbody tr td {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            padding: 3px 5px;
            font-size: 12px;
        }

        table.data-note {
            font-size: 12.5px;
        }

        table.data-ttd {
            width: 100%;
            font-size: 13.5px;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
            border: 1px solid #000;
        }

        table.data-ttd thead tr th {
            border: 1px solid #000;
        }

        table.data-ttd tbody tr td {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
        }

        .catatan {
            font-size: 12px;
        }
        .border-all td{
            border: 1px solid #000;
        }

    </style>
</head>

<body>
    <h2>PT. Media Awan Digital Indonesia</h2>
    <br>
    <h1 class="text-center">REIMBURSEMENT REQUEST FORM</h1>
    <table class="data-utama">
        <tr>
            <td width="90px">Request By</td>
            <td width="7px">:</td>
            <td width="300px">{{ $reimbursement->request->name }}</td>
            <td width="90px">Request Date</td>
            <td width="7px">:</td>
            <td>{{ $reimbursement->request_date }}</td>
        </tr>
        <tr>
            <td>Div/Dept</td>
            <td>:</td>
            <td>{{ $reimbursement->divisi->nama }}</td>
        </tr>
        <tr>
            <td>Organization</td>
            <td>:</td>
            <td>{{ $reimbursement->institusi->nama }}</td>
            <td>Leader</td>
            <td>:</td>
            <td>{{ $reimbursement->leader->name }}</td>
        </tr>
    </table>
    <table class="data-detail">
        <thead>
            <tr>
                <th height="20px" width="30px">No.</th>
                <th width="275px">Description</th>
                <th width="50px">Quantity</th>
                <th width="100px">Unit Price</th>
                <th width="130px">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reimbursement_detail as $key => $data)
                <tr>
                    <td class="text-center">{{ ++$key }}</td>
                    <td>{{ $data->description ?? '' }}</td>
                    <td class="text-center">{{ $data->quantity ?? 0 }}</td>
                    <td class="text-right">Rp. {{ number_format($data->unit_price) }}</td>
                    <td class="text-right">Rp. {{ number_format($data->total) }}</td>
                </tr>
            @empty
                <tr>
                    <td height="360px" width="50px"></td>
                    <td width="275px"></td>
                    <td width="70px"></td>
                    <td width="130px"></td>
                    <td width="160px"></td>
                </tr>
            @endforelse
            @if (!empty($subtotal))
                <tr class="border-all">
                    <td colspan="4" align="right"><b>Total</b></td>
                    <td align="right">Rp. {{ number_format($subtotal) }} </td>
                </tr>
            @endif
        </tbody>
    </table>
    <table class="data-note">
        <tr>
            <td height="100px" width="165px" valign="top">Notes (Reason of Request) :</td>
            <td valign="top">{{ $reimbursement->note ?? '-' }}</td>
        </tr>
    </table>
    <table class="data-ttd">
        <thead>
            <tr>
                <th height="20px" width="25%">Prepared</th>
                <th height="20px" width="25%">Checker</th>
                <th width="25%">Approved Leader</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center" height="120px" width="25%">{{ $reimbursement->request->name ?? '-' }}</td>
                <td class="text-center" width="25%">
                    {{ $reimbursement->leader->name ?? '-' }}<br><small><i>({{ $reimbursement->approval->approval_leader_status }})</i></small>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="catatan">
        <p class="mb-0">
                            {!! $reimbursement->approval->approval_leader_status == 'Tidak Disetujui' ? 'Alasan Leader Tidak Menyetujui: ' . $reimbursement->approval->leader_reason . '<br>' : '' !!}
                        </p>
        <p>
            Note :
        </p>
        <ol>
            <li>Untuk pengajuan event internal maupun external mohon untuk melampirkan detail budget</li>
            <li>Reimbursement request maksimal submit setiap hari Rabu dan pembayaran akan dijalakankan di hari
                Jumat</li>
        </ol>
    </div>
</body>

</html>
