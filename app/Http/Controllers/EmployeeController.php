<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function employee_index(Request $request, $leader_id)
    {
        $leader_name = User::where('id', $leader_id)->value('name');
        $user = User::when($request->cari, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->cari}%");
        })->where('role', '!=', 'Admin')
        ->where('leader_id', $leader_id)->latest()->paginate(15);
        $total_employee = $user->where('leader_id', $leader_id)->count();

        return view('employee.index', compact('user', 'total_employee', 'leader_name', 'leader_id'));
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

    public function employee_create($leader_id)
    {
        return view('employee.create', compact('leader_id'));
    }

    public function employee_select($leader_id)
    {
        $employee = User::where('role', '!=', 'Admin')->where('role', 'Leader')
        ->whereNull('leader_id')->pluck('name', 'id');
        return view('employee.select', compact('leader_id', 'employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->type_employee == 'employee_create'){
            $request->validate([
                'name'      => 'required',
                'password'  => 'required|min:5',
                'email'     => 'required|email|unique:users'
            ]);
            
            $leader = User::findOrFail($request->leader_id);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->email_verified_at = now();
            $user->password = Hash::make($request->password);
            $user->institusi_id = $leader->institusi_id;
            $user->divisi_id = $leader->divisi_id;
            $user->role = 'Employee';
            $user->leader_id = $leader->id;
            $user->save();

            return redirect()->route('leader_employee.index', $leader->id);
        }else{
            $user = User::findOrFail($request->employee_id);
            $user->leader_id = $request->leader_id;
            $user->save();

            return redirect()->route('leader_employee.index', $request->leader_id);
        }
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
        return view('employee.detail', compact('user'));
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
        return view('employee.edit', compact('user'));
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
        $user->save();
        return redirect()->route('leader_employee.index', $user->leader_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('leader_employee.index', $request->leader_id);
    }
}
