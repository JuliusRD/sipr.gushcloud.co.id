<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $purchase = Purchase::with('leader', 'institusi', 'request')->findOrFail($id);
        $purchase_detail = PurchaseDetail::where('purchase_id', $id)->get();
        $subtotal = $purchase_detail->sum('total');
        $pdf = PDF::loadView('report.index', compact('purchase', 'purchase_detail', 'subtotal'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
