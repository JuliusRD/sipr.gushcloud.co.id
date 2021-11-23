<?php

namespace App\Http\Controllers;

use App\Models\ReimbursementDetail;
use Illuminate\Http\Request;

class ReimbursementDetailController extends Controller
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
        //
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
        $pod = new ReimbursementDetail; 
        $pod->reimbursement_id = $request->reimbursement_id;
        $pod->description = $request->description;
        $pod->quantity = $request->quantity;
        $pod->unit_price = $request->unit_price;
        $pod->total = $request->quantity * $request->unit_price;
        $pod->save();

        return redirect($request->url_back);
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
        $reimbursement_detail = ReimbursementDetail::findOrFail($id);
        $url_update = route('reimbursement-detail.update', $reimbursement_detail->id);
		return json_encode(array('status'=>'ok', 'data'=>$reimbursement_detail, 'url_update'=>$url_update));
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
        $pod = ReimbursementDetail::findOrFail($id); 
        $pod->description = $request->description;
        $pod->quantity = $request->quantity;
        $pod->unit_price = $request->unit_price;
        $pod->total = $request->quantity * $request->unit_price;
        $pod->save();
        return redirect($request->url_back);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $reimbursement_detail = ReimbursementDetail::findOrFail($id);
        $reimbursement_detail->delete();
        return redirect($request->url_back);
    }
}
