<?php

namespace App\Http\Controllers;

use App\Models\LeaveStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\UserPermissionController;
use Auth;
class LeaveStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('create_leave_status', $user_permissions ) ){
            $leaveStatus = LeaveStatus::where('deleted_date', NULL)->get();
            return view('pages.leave_status.leave_status')->with('leaveStatus', $leaveStatus);
        }else{
            return redirect()->route('home');

        }    
        
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
            'value' => 'required',
            'color' => 'required',
        ]);
        $data = $request->all();
        $status = LeaveStatus::create($data);
        if($status){
            request()->session()->flash('success', 'Leave Status Created Successfully !!');
        }else{
            request()->session()->flash('error', 'Leave Status Not Created !!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveStatus  $leaveStatus
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveStatus $leaveStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveStatus  $leaveStatus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_leave_status', $user_permissions ) ){
            $leaveStatus = LeaveStatus::findOrFail($id);
            return view('pages.leave_status.edit')->with('leaveStatus', $leaveStatus);
        }else{
            return redirect()->route('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveStatus  $leaveStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $leaveStatus = LeaveStatus::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'value' => 'required',
            'color' => 'required',
        ]);
        $data = $request->all();
        $status = $leaveStatus->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'Leave Status Updated Successfully !!');
        }else{
            request()->session()->flash('error', 'Leave Status Not Updated !!');
        }
        return redirect()->route('leave-status.index');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveStatus  $leaveStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = LeaveStatus::destroy($id);
        if($status){
            request()->session()->flash('success', 'Leave Status Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'Leave Status Not Deleted !!');
        }
        return redirect()->back();
    }
}
