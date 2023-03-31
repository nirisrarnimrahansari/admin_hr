<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\LeaveStatus;
use App\Models\LeaveManagement;
use Illuminate\Http\Request;

use App\Http\Controllers\UserPermissionController;
use Auth;
use DB;
use App\Imports\LeaveImport;
use Maatwebsite\Excel\Facades\Excel;

class LeaveManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth()->user()->user_r == 1){
            $employees = Employee::where('deleted_date', NULL)->get();
            $leave_management = LeaveManagement::where('deleted_date', NULL)->get();
        }else{
            $employees = DB::table('employees')
                        ->select('*')
                        ->join('permissions', 'employees.id', '=', 'permissions.employee_id')
                        ->where('permissions.manager_id', Auth()->user()->id)
                        ->get();
            $leave_management_ids = DB::table('leave_management')
                                ->select('leave_management.id')
                                ->join('permissions', 'leave_management.employee_id', '=', 'permissions.employee_id')
                                ->where('permissions.manager_id', Auth()->user()->id)
                                ->get()->toArray();
            $leave_management = array();
            if( !empty( $leave_management_ids ) ){
                $leave_management_id = array();
                foreach( $leave_management_ids as $id ){
                    $leave_management_id[] = $id->id;
                }
                $leave_management = LeaveManagement::whereIn('id', $leave_management_id)->where('deleted_date', NULL)->get();
            }
        }
        $leave_status = LeaveStatus::where('deleted_date', NULL)->get();
        return view('pages.leave_management.leave_detail')->with('employees', $employees)->with('leave_status', $leave_status)->with('leave_management', $leave_management);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leave_status = LeaveStatus::where('deleted_date', NULL)->get();
        $employees = Employee::where('deleted_date', NULL)->get();
        return view('pages.leave_management.calender')->with('employees', $employees)->with('leave_status', $leave_status);
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
            'employee_id' => 'required',
            'leave_type' => 'required',
            'leave_date' => 'required',
        ]);
        $data = $request->all();
        $leave_date = $request->leave_date;
        $employee_id = $request->employee_id;
        $leave_type_id = $request->leave_type;
        $leave_month = $request->leave_month;
        $leave_year = $request->leave_year;
        $date_array = explode(',',$leave_date);
        $status = true;
        foreach($date_array as $key => $date){
            $leave_date = $date."-".$leave_month."-".$leave_year;
            $leave_date = date('Y-m-d', strtotime($leave_date) );
           
            $data['leave_date'] = $leave_date;  
            $old_leave = LeaveManagement::where('deleted_date', NULL)->where('leave_date', $leave_date)->where('employee_id', $employee_id)->first();
            
            if($old_leave){
                $old_leave->fill(array('leave_type'=>$leave_type_id))->save();
            }else{
                $status = LeaveManagement::create($data); 
            }
        }   
        if($status){
            request()->session()->flash('success', 'Leave Management Created Successfully !!');
        }else{
            request()->session()->flash('error', 'Leave Management Not Created !!');
        }
        return redirect()->route('leave-management.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveManagement  $LeaveManagement
     * @return \Illuminate\Http\Response
     */

    public function show($month, $year, $employee_id)
    {
        if(Auth()->user()->user_r == 1){
            $employees = Employee::where('deleted_date', NULL)->get();
        }else{
            $employees = DB::table('employees')
            ->select('*')
            ->join('permissions', 'employees.id', '=', 'permissions.employee_id')
            ->where('permissions.manager_id', Auth()->user()->id)
            ->get();
        }
        $daysInMonth = cal_days_in_month(0, $month, $year);
        //current month first day
        $start_month_date = date('Y-m-d',strtotime( $year.'-'.$month.'-01' ));
        //current month last day
        $end_month_date = date('Y-m-d',strtotime( $year.'-'.$month.'-'.$daysInMonth ));
        $holidays = Holiday::where('deleted_date', NULL)->where('holiday_date', '>=', $start_month_date)->where('holiday_date', '<=', $end_month_date)->get();
        $leaves = LeaveManagement::where('deleted_date', NULL)->where('leave_date', '>=', $start_month_date)->where('leave_date', '<=', $end_month_date)->where('employee_id', $employee_id)->get();
        $leave_status = LeaveStatus::where('deleted_date', NULL)->get();
        return view('pages.leave_management.calender')->with('employees', $employees)->with('month', $month)->with('year', $year)->with('leave_status', $leave_status)->with('employee_id', $employee_id)->with('holidays', $holidays)->with('leaves', $leaves);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveManagement  $LeaveManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_leave_management', $user_permissions ) ){
            $leave_management = LeaveManagement::findOrFail($id);
            $leave_status = LeaveStatus::where('deleted_date', NULL)->get();
            $employees = Employee::where('deleted_date', NULL)->get();
        return view('pages.leave_management.edit')->with('leave_management', $leave_management)->with('employees', $employees)->with('leave_status', $leave_status);
        }else{
            return redirect()->route('home');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveManagement  $LeaveManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $leave_management = LeaveManagement::findOrFail($id);
        $request->validate([
            'employee_id' => 'required',
            'leave_type' => 'required',
            'leave_date'=> 'required',
        ]);
        $data = $request->all();
        $status = $leave_management->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'Leave Management Updated Successfully !!');
        }else{
            request()->session()->flash('error', 'Leave Management Not Updated !!');
        }
        return redirect()->route('leave-management.index');
    }

    public function updateType(Request $request, $id)
    {
        $leave_management = LeaveManagement::findOrFail($id);
        $request->validate([
            'leave_type' => 'required',
        ]);
        $data = $request->all();
        if( !$request->leave_type ){
             $status = LeaveManagement::destroy($id);
        }else{
            $status = $leave_management->fill($data)->save();
        }
        if($status){
            request()->session()->flash('success', 'Leave Type updated Successfully !!');
        }else{
            request()->session()->flash('error', 'Leave Type not updated !!');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveManagement  $LeaveManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $status = LeaveManagement::destroy($id);
        if($status){
            request()->session()->flash('success', 'Leave Management Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'Leave Management not Deleted !!');
        }
        return redirect()->back();
    }
    public function import( Request $request )
    {
        $rows = Excel::toArray(new LeaveImport, $request->file('file'));
        $leave_status = LeaveStatus::where('deleted_date', NULL)->pluck('value', 'id')->toArray();
        foreach( $rows[0] as $leaves_data ):
            $employee_id = Employee::where('biometric_id', $leaves_data[0])->pluck('id')->first();
            $i = 1;
            if($employee_id && ( in_array( 'P', $leaves_data, true ) || in_array( '½P', $leaves_data, true ) )){
                foreach($leaves_data as $key => $data){
                    if( 0 != $key && !empty($data) )
                    {
                        $leave_date = $request->year."-".$request->month."-".$i;
                        $leave_date = date('Y-m-d', strtotime($leave_date) );
                        $holiday = Holiday::where('holiday_date', $leave_date)->first();
                        if($holiday){
                            continue;
                        }

                        if( 'A' == $data ){
                            $leave_type_id = array_search(-1, $leave_status);
                            $old_leave = LeaveManagement::where('deleted_date', NULL)->where('leave_date', $leave_date)->where('employee_id', $employee_id)->first();
                        if($old_leave){
                                $old_leave->fill(array('leave_type'=>$leave_type_id))->save();
                            }else{
                                $data = array('employee_id'=>$employee_id, 'leave_type' => $leave_type_id, 'leave_date' => $leave_date);
                                $status = LeaveManagement::create($data);
                            }
                        }elseif( '½P' == $data ){
                            $leave_type_id = array_search(-0.5, $leave_status);
                            $old_leave = LeaveManagement::where('deleted_date', NULL)->where('leave_date', $leave_date)->where('employee_id', $employee_id)->first();
                            if($old_leave){
                                $old_leave->fill(array('leave_type'=>$leave_type_id))->save();
                            }else{
                                $data = array('employee_id'=>$employee_id, 'leave_type' => $leave_type_id, 'leave_date' => $leave_date);
                                $status = LeaveManagement::create($data);
                            }
                        }elseif( 'P' == $data ){
                            LeaveManagement::where('deleted_date', NULL)->where('leave_date', $leave_date)->where('employee_id', $employee_id)->delete();
                        }
                        $i++;
                    }
                }
            }
        endforeach;
        request()->session()->flash('success', 'Leave Type updated Successfully !!');
        return redirect()->back();
    }
}

