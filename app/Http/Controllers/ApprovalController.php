<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\History;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApprovalController extends Controller
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
        $purchase = Purchase::with('ga', 'leader', 'institusi', 'approval', 'request')->when($request->cari, function ($query) use ($request) {
            $query->where('purchase_code', 'like', "%{$request->cari}%");
        });
        if (Auth::User()->role !== 'Admin') {
            $purchase = $purchase->where('ga_id', Auth::id())->orWhere('leader_id', Auth::id())->orWhere('finance_id', Auth::id());
        }
        $purchase = $purchase->latest()->paginate(15);

        return view('approval.index', compact('purchase'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::with('leader', 'institusi', 'approval', 'divisi')->findOrFail($id);
        $purchase_detail = PurchaseDetail::where('purchase_id', $id)->get();
        $current_user = User::with('divisi')->findOrFail($purchase->request_by);
        $subtotal = $purchase_detail->sum('total');
        return view('approval.detail', compact('purchase_detail', 'purchase', 'current_user', 'id', 'subtotal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $approval = Approval::where('purchase_id', $id)->firstOrFail();
        if ($approval->approval_ga_id == Auth::id()) {
            $approval->approval_ga_date = now();
            $approval->approval_ga_status = $request->persetujuan;
            if($request->persetujuan == 'Tidak Disetujui'){
                $approval->ga_reason = $request->alasan_tidak_disetujui;
            }
            $approval->save();
        }
        if ($approval->approval_leader_id == Auth::id()) {
            $approval->approval_leader_date = now();
            $approval->approval_leader_status = $request->persetujuan;
            if($request->persetujuan == 'Tidak Disetujui'){
                $approval->leader_reason = $request->alasan_tidak_disetujui;
            }
            $approval->save();
        }
        if ($approval->approval_finance_id == Auth::id()) {
            $approval->approval_finance_date = now();
            $approval->approval_finance_status = $request->persetujuan;
            if($request->persetujuan == 'Tidak Disetujui'){
                $approval->finance_reason = $request->alasan_tidak_disetujui;
            }
            $approval->save();
        }

        if ($approval->approval_ga_id == Auth::id() || $approval->approval_leader_id == Auth::id() || $approval->approval_finance_id == Auth::id()) {
            if ($request->persetujuan == 'Menunggu Persetujuan') {
                $status = 'menunggu persetujuan';
            } elseif ($request->persetujuan == 'Disetujui') {
                $status = 'menyetujui';
            } elseif ($request->persetujuan == 'Tidak Disetujui') {
                $status = 'tidak menyetujui';
            } else {
                $status = 'menunggu persetujuan';
            }
            $histori = new History;
            $histori->purchase_id = $id;
            $histori->user_id = Auth::id();
            $histori->status = $status;
            $histori->save();
        }

        if($request->persetujuan !== 'Menunggu Persetujuan'){
            $purchase = Purchase::with('request', 'leader', 'finance')->findOrFail($id);
            $rpo_mail = $purchase->request->email;
            if($approval->approval_ga_id == Auth::id()){
                $cc_mail = $purchase->leader->email;
            }elseif($approval->approval_leader_id == Auth::id()){
                $cc_mail = $purchase->finance->email;
            }else{
                $cc_mail = 'notif.pr@gmail.com';
            }
            if($approval->approval_finance_id == Auth::id() && $request->persetujuan == 'Disetujui'){
                try {
                    Mail::to($rpo_mail)
                        ->cc([$purchase->leader->email, $purchase->ga->email, $purchase->finance->email])
                        ->send(new \App\Mail\ApprovalLampiranMail($histori->id));                   
                    if (count(Mail::failures()) > 0) {
                        return redirect()->route('approval.show', $id);
                    }
                } catch (\Swift_TransportException $transportExp) {
                    return redirect()->route('approval.show', $id);
                }
            }else{
                try {
                    Mail::to($rpo_mail)
                        ->send(new \App\Mail\ApprovalMail($histori->id));
                    
                    Mail::to($cc_mail)
                        ->send(new \App\Mail\PurchaseOrderMail($id));

                    if (count(Mail::failures()) > 0) {
                        return redirect()->route('approval.show', $id);
                    }
                } catch (\Swift_TransportException $transportExp) {
                    return redirect()->route('approval.show', $id);
                }
            }           
        }

        return redirect()->route('approval.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
