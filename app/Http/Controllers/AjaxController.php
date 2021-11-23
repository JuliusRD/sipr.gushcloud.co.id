<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
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
    public function getcurrentdivisi(Request $request)
	{
		$currentdivisi = Divisi::where('id', Auth::User()->divisi_id)->value('nama');
		return json_encode(array('status'=>'ok', 'data'=>$currentdivisi));
	}

    public function getdivisifrominstitusi(Request $request)
    {
        $divisi = Divisi::where('institusi_id', $request->institusi_id)->pluck('nama', 'id')->toJson();
		return json_encode(array('status'=>'ok', 'data'=>$divisi));
    }

    public function getleaderfromdivisi(Request $request)
    {
        $leader = User::where('role', 'Leader')->where('divisi_id', $request->divisi_id)->pluck('name', 'id')->toJson();
		return json_encode(array('status'=>'ok', 'data'=>$leader));
    }

    public function getleaderfrominstitusi(Request $request)
    {
        $leader = User::where('role', 'Leader')->pluck('name', 'id')->toJson();
		return json_encode(array('status'=>'ok', 'data'=>$leader));
    }
}
