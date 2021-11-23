<?php

namespace App\Http\Controllers;

use App\Models\Reimbursement;
use App\Models\ReimbursementDetail;
use Illuminate\Http\Request;
use PDF;

class ReportReimbursementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $reimbursement = Reimbursement::with('leader', 'institusi', 'request')->findOrFail($id);
        $reimbursement_detail = ReimbursementDetail::where('reimbursement_id', $id)->get();
        $subtotal = $reimbursement_detail->sum('total');
        $pdf = PDF::loadView('reportreimbursement.index', compact('reimbursement', 'reimbursement_detail', 'subtotal'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
