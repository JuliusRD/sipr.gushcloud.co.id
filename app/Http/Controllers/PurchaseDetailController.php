<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
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
        $pod = new PurchaseDetail; 
        $pod->purchase_id = $request->purchase_id;
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
        $purchase_detail = PurchaseDetail::findOrFail($id);
        $url_update = route('purchase-detail.update', $purchase_detail->id);
		return json_encode(array('status'=>'ok', 'data'=>$purchase_detail, 'url_update'=>$url_update));
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
        $pod = PurchaseDetail::findOrFail($id); 
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
        $purchase_detail = PurchaseDetail::findOrFail($id);
        $purchase_detail->delete();
        return redirect($request->url_back);
    }
}
