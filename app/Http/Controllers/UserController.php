<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Institusi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $user = User::with(['employee','institusi', 'divisi'])->when($request->cari, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->cari}%");
        })->where('role', 'Leader')->latest()->paginate(15);
        // dd($user);
        $total_leader = $user->where('role', 'Leader')->count();
        return view('user.index', compact('user', 'total_leader'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institusi = Institusi::orderBy('nama', 'asc')->pluck('nama','id')->prepend('Select Organization','');
        $divisi = Divisi::orderBy('nama', 'asc')->pluck('nama', 'id');
        return view('user.create', compact('institusi', 'divisi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'password'  => 'required|min:5',
            'email'     => 'required|email|unique:users'
        ]);
 
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = Hash::make($request->password);
        $user->institusi_id = $request->institusi_id;
        $user->divisi_id = $request->divisi_id;
        $user->role = $request->role;
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.detail', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $institusi = Institusi::pluck('nama','id')->prepend('Select Organization','');
        $divisi = Divisi::pluck('nama', 'id')->prepend('Select Division','');
        return view('user.edit', compact('user', 'institusi', 'divisi'));
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
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->institusi_id = $request->institusi_id;
        $user->divisi_id = $request->divisi_id;
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index');
    }
}
