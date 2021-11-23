<?php

namespace App\Http\Controllers;

use App\Models\Institusi;
use Illuminate\Http\Request;

class InstitusiController extends Controller
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
        $institusi = Institusi::with('divisi')->when($request->cari, function ($query) use ($request) {
            $query
            ->where('nama', 'like', "%{$request->cari}%");
        })->paginate(15);
        
        $total_institusi = $institusi->count();
        return view('institusi.index', compact('institusi', 'total_institusi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('institusi.create');
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
        Institusi::create($data);
        return redirect()->route('institusi.index');
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
        $institusi = Institusi::findOrFail($id);
        return view('institusi.edit', compact('institusi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institusi $institusi)
    {
        $data = $request->all();
        $institusi->update($data);
        return redirect()->route('institusi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institusi $institusi)
    {
        $institusi->delete();
        return redirect()->route('institusi.index');
    }
}
