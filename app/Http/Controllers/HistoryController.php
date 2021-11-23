<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HistoryController extends Controller
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
            $history = History::whereHas('purchase', function ($q) {
                $q
                ->where('ga_id', Auth::id())
                ->orWhere('leader_id', Auth::id())
                ->orWhere('finance_id', Auth::id())
                ->orWhere('request_by', Auth::id());
            })->latest()->paginate(15);
        }else if(Auth::User()->role == 'Employee') {
            $history = History::whereHas('purchase', function ($q) {
                $q
                ->where('request_by', Auth::id());
            })->latest()->paginate(15);
        }else{
            $history = History::latest()->paginate(15);
        }
        return view('history.index', compact('history'));
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
        $histori = new History;
        $histori->purchase_id = $request->purchase_id;
        $histori->user_id = Auth::id();
        $histori->status = $request->status;
        $histori->save();        

        $purchase = Purchase::with('ga', 'leader', 'finance')->findOrFail($request->purchase_id);
        $ga_mail = $purchase->ga->email;

        try {
            Mail::to($ga_mail)
                ->send(new \App\Mail\PurchaseOrderMail($request->purchase_id));

            if (count(Mail::failures()) > 0) {
                return redirect()->route('purchase.index');
            }
        } catch (\Swift_TransportException $transportExp) {
            return redirect()->route('purchase.index');
        }

        return redirect()->route('purchase.index');
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
