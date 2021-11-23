<?php

namespace App\Http\Controllers;

use App\Models\ApprovalReimbursement;
use App\Models\Divisi;
use App\Models\HistoryReimbursement;
use App\Models\Institusi;
use App\Models\Reimbursement;
use App\Models\ReimbursementDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReimbursementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $reimbursement = Reimbursement::with('leader', 'institusi', 'approval', 'request')->when($request->cari, function ($query) use ($request) {
            $query->where('reimbursement_code', 'like', "%{$request->cari}%");
        });
        if (Auth::User()->role !== 'Admin') {
            $reimbursement = $reimbursement->where('request_by', Auth::id());
        }
        $reimbursement = $reimbursement->latest()->paginate(15);
        // dd($purchase[0]->request->name);
        return view('reimbursement.index', compact('reimbursement'));
    }

    public function create()
    {
        $current_user = User::with('divisi')->findOrFail(Auth::id());
        $institusi = Institusi::pluck('nama', 'id')->prepend('Select Organization', '');
        $divisi = Divisi::pluck('nama', 'id')->prepend('Select Division', '');
        $leader = User::where('role', 'Leader')->pluck('name', 'id')->prepend('Select Leader', '');
        return view('reimbursement.create', compact('current_user', 'institusi', 'divisi', 'leader'));
    }

    public function store(Request $request)
    {
        $po = new Reimbursement;
        $po->request_by = Auth::id();
        $po->divisi_id = $request->divisi_id;
        $po->institusi_id = $request->institusi_id;
        $po->leader_id = $request->leader_id;
        $po->request_date = $request->request_date;
        $po->note = $request->note;
        $po->save();

        $kode = Reimbursement::findOrFail($po->id);
        $kode->reimbursement_code = 'GCID/RR/' . date('Y') . '/' . $kode->id;
        $kode->save();

        $approval = new ApprovalReimbursement;
        $approval->reimbursement_id = $po->id;
        $approval->approval_leader_id = $request->leader_id;
        $approval->approval_leader_date = now();
        $approval->approval_leader_status = 'Menunggu Persetujuan';
        $approval->save();

        return redirect()->route('reimbursement.detail', $kode->id);
    }

    public function show($id)
    {
        $reimbursement = Reimbursement::with('leader', 'institusi', 'divisi')->findOrFail($id);
        $reimbursement_detail = ReimbursementDetail::where('reimbursement_id', $id)->get();
        $current_user = User::with('divisi')->findOrFail($reimbursement->request_by);
        $subtotal = $reimbursement_detail->sum('total');
        // dd($subtotal);
        return view('reimbursement.show', compact('reimbursement_detail', 'reimbursement', 'current_user', 'id', 'subtotal'));
    }

    public function detail($id)
    {
        $reimbursement = Reimbursement::with('leader', 'institusi', 'divisi')->findOrFail($id);
        $reimbursement_detail = ReimbursementDetail::where('Reimbursement_id', $id)->paginate(15);
        $current_user = User::with('divisi')->findOrFail($reimbursement->request_by);
        // dd($purchase);
        return view('reimbursement.detail', compact('reimbursement_detail', 'reimbursement', 'current_user', 'id'));
    }

    public function detail_edit($id)
    {
        $reimbursement = Reimbursement::with('leader', 'institusi', 'divisi')->findOrFail($id);
        $reimbursement_detail = ReimbursementDetail::where('reimbursement_id', $id)->paginate(15);
        $current_user = User::with('divisi')->findOrFail($reimbursement->request_by);
        return view('reimbursement.detail_edit', compact('reimbursement_detail', 'reimbursement', 'current_user', 'id'));
    }

    public function edit($id)
    {
        $current_user = User::with('divisi')->findOrFail(Auth::id());
        $institusi = Institusi::pluck('nama', 'id')->prepend('Select Organization', '');
        $divisi = Divisi::pluck('nama', 'id')->prepend('Select Organization First', '');
        $reimbursement = Reimbursement::findOrFail($id);
        // dd($purchase);
        $leader = User::where('role', 'Leader')->pluck('name', 'id')->prepend('Select Leader', '');
        return view('reimbursement.edit', compact('current_user', 'institusi', 'divisi', 'reimbursement', 'leader'));
    }

    public function update(Request $request, $id)
    {
        $po = Reimbursement::findOrFail($id);
        $po->institusi_id = $request->institusi_id;
        $po->divisi_id = $request->divisi_id;
        $po->leader_id = $request->leader_id;
        $po->request_date = $request->request_date;
        $po->note = $request->note;
        $po->save();

        $approval = ApprovalReimbursement::find($po->id);
        if (!empty($approval)) {
            $approval->approval_leader_id = $request->leader_id;
            $approval->approval_leader_date = now();
            $approval->approval_leader_status = 'Menunggu Persetujuan';
            $approval->save();
        }

        return redirect()->route('reimbursement.detail_edit', $po->id);
    }

    public function destroy($id)
    {
        HistoryReimbursement::where('reimbursement_id', $id)->delete();
        ApprovalReimbursement::where('reimbursement_id', $id)->delete();
        ReimbursementDetail::where('reimbursement_id', $id)->delete();
        Reimbursement::findOrFail($id)->delete();
        return redirect()->route('reimbursement.index');
    }
    
}
