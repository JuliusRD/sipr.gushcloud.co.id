<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Institusi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
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
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $institusi = Institusi::pluck('nama','id')->prepend('Pilih Institusi','');
        $divisi = Divisi::pluck('nama', 'id')->prepend('Pilih Institusi','');
        return view('profile.index', compact('user', 'institusi', 'divisi'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('home');
    }
}
