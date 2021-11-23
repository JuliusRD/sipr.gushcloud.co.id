<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Divisi;
use App\Models\History;
use App\Models\Institusi;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $purchase = Purchase::with('leader', 'institusi', 'approval', 'request')->when($request->cari, function ($query) use ($request) {
            $query->where('purchase_code', 'like', "%{$request->cari}%");
        });
        if (Auth::User()->role !== 'Admin') {
            $purchase = $purchase->where('request_by', Auth::id());
        }
        $purchase = $purchase->latest()->paginate(15);
        // dd($purchase[0]->request->name);
        return view('purchase.index', compact('purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_user = User::with('divisi')->findOrFail(Auth::id());
        $institusi = Institusi::pluck('nama', 'id')->prepend('Select Organization', '');
        $divisi = Divisi::pluck('nama', 'id')->prepend('Select Division', '');
        $finance = User::where('role', 'Leader')->whereHas('divisi', function ($q) {
            $q
                ->where('nama', 'like', '%Finance%');
        })->pluck('name', 'id')->prepend('Select Finance', '');
        $finance = User::where('role', 'Leader')->whereHas('divisi', function ($q) {
            $q
                ->where('nama', 'like', '%Finance%')->orWhere('nama', 'like', '%Operation%');
        })->pluck('name', 'id')->prepend('Select Finance', '');
        $leader = User::where('role', 'Leader')->pluck('name', 'id')->prepend('Select Leader', '');
        return view('purchase.create', compact('current_user', 'institusi', 'finance', 'divisi', 'leader'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ga_id = User::where('email', 'hari.apri@gushcloud.com')->value('id');
        $po = new Purchase;
        $po->request_by = Auth::id();
        $po->divisi_id = $request->divisi_id;
        $po->institusi_id = $request->institusi_id;
        $po->ga_id = $ga_id;
        $po->leader_id = $request->leader_id;
        $po->finance_id = $request->finance_id;
        $po->request_date = $request->request_date;
        $po->due_date = $request->due_date;
        $po->note = $request->note;
        $po->save();

        $kode = Purchase::findOrFail($po->id);
        $kode->purchase_code = 'GCID/PR/' . date('Y') . '/' . $kode->id;
        $kode->save();

        $approval = new Approval;
        $approval->purchase_id = $po->id;
        $approval->approval_ga_id = $ga_id;
        $approval->approval_ga_date = now();
        $approval->approval_ga_status = 'Menunggu Persetujuan';
        $approval->approval_leader_id = $request->leader_id;
        $approval->approval_leader_date = now();
        $approval->approval_leader_status = 'Menunggu Persetujuan';
        $approval->approval_finance_id = $request->finance_id;
        $approval->approval_finance_date = now();
        $approval->approval_finance_status = 'Menunggu Persetujuan';
        $approval->save();

        return redirect()->route('purchase.detail', $kode->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::with('leader', 'institusi', 'divisi')->findOrFail($id);
        $purchase_detail = PurchaseDetail::where('purchase_id', $id)->get();
        $current_user = User::with('divisi')->findOrFail($purchase->request_by);
        $subtotal = $purchase_detail->sum('total');
        // dd($subtotal);
        return view('purchase.show', compact('purchase_detail', 'purchase', 'current_user', 'id', 'subtotal'));
    }

    public function detail($id)
    {
        $purchase = Purchase::with('leader', 'institusi', 'divisi')->findOrFail($id);
        $purchase_detail = PurchaseDetail::where('purchase_id', $id)->paginate(15);
        $current_user = User::with('divisi')->findOrFail($purchase->request_by);
        // dd($purchase);
        return view('purchase.detail', compact('purchase_detail', 'purchase', 'current_user', 'id'));
    }

    public function detail_edit($id)
    {
        $purchase = Purchase::with('leader', 'institusi', 'divisi')->findOrFail($id);
        $purchase_detail = PurchaseDetail::where('purchase_id', $id)->paginate(15);
        $current_user = User::with('divisi')->findOrFail($purchase->request_by);
        return view('purchase.detail_edit', compact('purchase_detail', 'purchase', 'current_user', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $current_user = User::with('divisi')->findOrFail(Auth::id());
        $institusi = Institusi::pluck('nama', 'id')->prepend('Select Organization', '');
        $divisi = Divisi::pluck('nama', 'id')->prepend('Select Organization First', '');
        $purchase = Purchase::findOrFail($id);
        // dd($purchase);
        $leader = User::where('role', 'Leader')->pluck('name', 'id')->prepend('Select Leader', '');
        $finance = User::where('role', 'Leader')->whereHas('divisi', function ($q) {
            $q
                ->where('nama', 'like', '%Finance%');
        })->pluck('name', 'id')->prepend('Select Finance', '');
        return view('purchase.edit', compact('current_user', 'institusi', 'divisi', 'purchase', 'leader', 'finance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ga_id = User::where('email', 'hari.apri@gushcloud.com')->value('id');
        $po = Purchase::findOrFail($id);
        $po->institusi_id = $request->institusi_id;
        $po->divisi_id = $request->divisi_id;
        $po->ga_id = $ga_id;
        $po->leader_id = $request->leader_id;
        $po->finance_id = $request->finance_id;
        $po->request_date = $request->request_date;
        $po->due_date = $request->due_date;
        $po->note = $request->note;
        $po->save();

        $approval = Approval::find($po->id);
        if (!empty($approval)) {
            $approval->approval_ga_id = $ga_id;
            $approval->approval_ga_date = now();
            $approval->approval_ga_status = 'Menunggu Persetujuan';
            $approval->approval_leader_id = $request->leader_id;
            $approval->approval_leader_date = now();
            $approval->approval_leader_status = 'Menunggu Persetujuan';
            $approval->approval_finance_id = $request->finance_id;
            $approval->approval_finance_date = now();
            $approval->approval_finance_status = 'Menunggu Persetujuan';
            $approval->save();
        }

        return redirect()->route('purchase.detail_edit', $po->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        History::where('purchase_id', $id)->delete();
        Approval::where('purchase_id', $id)->delete();
        PurchaseDetail::where('purchase_id', $id)->delete();
        Purchase::findOrFail($id)->delete();
        return redirect()->route('purchase.index');
    }
}
