<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Divisi;
use App\Models\History;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
    public function index(Request $request)
    {        
        if (Auth::User()->role == 'Leader' or Auth::User()->email == 'hari.apri@gushcloud.com') {
            $history = History::whereHas('purchase', function ($q) {
                $q
                    ->where('ga_id', Auth::id())
                    ->orWhere('leader_id', Auth::id())
                    ->orWhere('finance_id', Auth::id())
                    ->orWhere('request_by', Auth::id());
            })->latest()->limit(5)->get();
        } else if (Auth::User()->role == 'Employee') {
            $history = History::whereHas('purchase', function ($q) {
                $q
                    ->where('request_by', Auth::id());
            })->latest()->limit(5)->get();
        } else {
            $history = History::latest()->limit(5)->get();
        }
        return view('home', compact('history'));
    }
}
