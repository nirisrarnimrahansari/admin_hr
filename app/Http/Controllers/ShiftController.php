<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

use App\Http\Controllers\UserPermissionController;
use Auth;
class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
            $shift = Shift::where('deleted_date', NULL)->get();
            return view('pages.shift.list')->with('shift', $shift);
       
        
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
        $request->validate([
            'name' => 'required',
            'login_time' => 'required',
            'logout_time' => 'required',
            'buffer_time' => 'required|numeric',
        ]);
        $data = $request->all();
        $status = Shift::create($data);
        if($status){
            request()->session()->flash('success', 'Shift Created Successfully !!');
        }else{
            request()->session()->flash('error', 'Shift Not Created !!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_shift', $user_permissions ) ){
            $shift = Shift::findOrFail($id);
            return view('pages.shift.edit')->with('shift', $shift);
        }else{
            return redirect()->route('home');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $shift = Shift::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'login_time' => 'required',
            'logout_time' => 'required',
            'buffer_time' => 'required',
        ]);
        $data = $request->all();
        $status = $shift->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'Shift Updated Successfully !!');
        }else{
            request()->session()->flash('error', 'Shift Not Updated !!');
        }
        return redirect()->route('shift.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $status = Shift::destroy($id);
        if($status){
            request()->session()->flash('success', 'Shifting Time Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'Shifting Time Not Deleted !!');
        }
        return redirect()->back();
    }
}
