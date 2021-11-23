<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Institusi;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Div;

class DivisiController extends Controller
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
        //
    }

    public function divisi_index(Request $request, $institusi_id)
    {
        $institusi_name = Institusi::where('id', $institusi_id)->value('nama');
        $divisi = Divisi::with('institusi')->when($request->cari, function ($query) use ($request) {
            $query
            ->where('nama', 'like', "%{$request->cari}%");
        })->where('institusi_id', $institusi_id)->orderBy('nama', 'asc')->paginate(15);
        $total_divisi = $divisi->count();
        return view('divisi.index', compact('divisi', 'total_divisi', 'institusi_name', 'institusi_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('divisi.create');
    }

    public function divisi_create($institusi_id)
    {
        $institusi_name = Institusi::where('id', $institusi_id)->value('nama');
        return view('divisi.create', compact('institusi_id', 'institusi_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Divisi::create($data);
        return redirect()->route('institusi_divisi.index', $request->institusi_id);
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
        $divisi = Divisi::with('institusi')->findOrFail($id);
        return view('divisi.edit', compact('divisi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Divisi $divisi)
    {
        $data = $request->all();
        $divisi->update($data);
        return redirect()->route('institusi_divisi.index', $divisi->institusi_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Divisi $divisi)
    {
        $divisi->delete();
        return redirect()->route('institusi_divisi.index', $request->institusi_id);
    }
}
