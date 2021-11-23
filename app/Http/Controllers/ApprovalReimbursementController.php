<?php

namespace App\Http\Controllers;

use App\Models\ApprovalReimbursement;
use App\Models\Reimbursement;
use App\Models\ReimbursementDetail;
use App\Models\HistoryReimbursement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApprovalReimbursementController extends Controller
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
        $reimbursement = Reimbursement::with('leader', 'institusi', 'approval', 'request')->when($request->cari, function ($query) use ($request) {
            $query->where('reimbursement_code', 'like', "%{$request->cari}%");
        });
        if (Auth::User()->role !== 'Admin') {
            $reimbursement = $reimbursement->where('leader_id', Auth::id());
        }
        $reimbursement = $reimbursement->latest()->paginate(15);

        return view('approvalreimbursement.index', compact('reimbursement'));
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
        $reimbursement = Reimbursement::with('leader', 'institusi', 'approval', 'divisi')->findOrFail($id);
        $reimbursement_detail = ReimbursementDetail::where('reimbursement_id', $id)->get();
        $current_user = User::with('divisi')->findOrFail($reimbursement->request_by);
        $subtotal = $reimbursement_detail->sum('total');
        return view('approvalreimbursement.detail', compact('reimbursement_detail', 'reimbursement', 'current_user', 'id', 'subtotal'));
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
        $approval = ApprovalReimbursement::where('reimbursement_id', $id)->firstOrFail();
        if ($approval->approval_leader_id == Auth::id()) {
            $approval->approval_leader_date = now();
            $approval->approval_leader_status = $request->persetujuan;
            if($request->persetujuan == 'Tidak Disetujui'){
                $approval->leader_reason = $request->alasan_tidak_disetujui;
            }
            $approval->save();
        }

        if ($approval->approval_leader_id == Auth::id()) {
            if ($request->persetujuan == 'Menunggu Persetujuan') {
                $status = 'menunggu persetujuan';
            } elseif ($request->persetujuan == 'Disetujui') {
                $status = 'menyetujui';
            } elseif ($request->persetujuan == 'Tidak Disetujui') {
                $status = 'tidak menyetujui';
            } else {
                $status = 'menunggu persetujuan';
            }
            $histori = new HistoryReimbursement();
            $histori->reimbursement_id = $id;
            $histori->user_id = Auth::id();
            $histori->status = $status;
            $histori->save();
        }

        if($request->persetujuan !== 'Menunggu Persetujuan'){
            $reimbursement = Reimbursement::with('request', 'leader')->findOrFail($id);
            $rpo_mail = $reimbursement->request->email;
            if($approval->approval_leader_id == Auth::id()){
                $cc_mail = $reimbursement->leader->email;
            }else{
                $cc_mail = 'notif.pr@gmail.com';
            }
            if($approval->approval_leader_id == Auth::id() && $request->persetujuan == 'Disetujui'){
                try {
                    Mail::to($rpo_mail)
                        ->cc([$reimbursement->leader->email])
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
                        ->send(new \App\Mail\ApprovalReimbursementMail($histori->id));
                    
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
