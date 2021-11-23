<?php

namespace App\Http\Controllers;

use App\Models\HistoryReimbursement;
use App\Models\Reimbursement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HistoryReimbursementController extends Controller
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
    public function index()
    {
        if (Auth::User()->role == 'Leader' or Auth::User()->email == 'hari.apri@gushcloud.com') {
            $history = Reimbursement::whereHas('reimbursement', function ($q) {
                $q
                ->where('leader_id', Auth::id());
            })->latest()->paginate(15);
        }else if(Auth::User()->role == 'Employee') {
            $history = HistoryReimbursement::whereHas('reimbursement', function ($q) {
                $q
                ->where('request_by', Auth::id());
            })->latest()->paginate(15);
        }else{
            $history = HistoryReimbursement::latest()->paginate(15);
        }
        return view('historyreimbursement.index', compact('history'));
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
        $histori = new HistoryReimbursement();
        $histori->reimbursement_id = $request->reimbursement_id;
        $histori->user_id = Auth::id();
        $histori->status = $request->status;
        $histori->save();        

        $reimbursement = Reimbursement::with('leader')->findOrFail($request->reimbursement_id);
        $leader_mail = $reimbursement->leader->email;

        try {
            Mail::to($leader_mail)
                ->send(new \App\Mail\PurchaseOrderMail($request->reimbursement_id));

            if (count(Mail::failures()) > 0) {
                return redirect()->route('reimbursement.index');
            }
        } catch (\Swift_TransportException $transportExp) {
            return redirect()->route('reimbursement.index');
        }

        return redirect()->route('reimbursement.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
