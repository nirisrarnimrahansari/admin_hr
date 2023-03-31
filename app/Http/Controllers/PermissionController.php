<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\UserPermissionController;
use Auth;
use DB;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $user = User::where('deleted_date', NULL)->get();
        $permission = Permission::with('employee_info')->with('manager_info')->where('deleted_date', NULL)->get();
    if(Auth()->user()->user_r == 1){
        $employees = Employee::where('deleted_date', NULL)->get();
    }else{
        $employees = DB::table('employees') 
        ->select('*')
        ->join('permissions', 'employees.id', '=', 'permissions.employee_id')
        ->where('permissions.manager_id', Auth()->user()->id)
        ->get();
    }
  
    return view('pages.user.permission')->with('employees', $employees)->with('user', $user)->with('permission', $permission);
 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('deleted_date', NULL)->get();
        $permission = Permission::where('deleted_date', NULL)->get();
        $employees = Employee::where('deleted_date', NULL)->get();
        return view('pages.user.permission')->with('employees', $employees)->with('permission', $permission)->with('user', $user);
   
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
            'manager_id' => 'required',
        ]);
        $data = $request->all();
        $status = Permission::create($data);
        if($status){
            request()->session()->flash('success', 'Permission Created Successfully !!');
        }else{
            request()->session()->flash('error', 'Permission Not Created !!');
        }
        return redirect()->route('permission.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_manager_access', $user_permissions ) ){
            $permission = Permission::findOrFail($id);
            $employees = Employee::where('deleted_date', NULL)->get();
            $user = User::where('deleted_date', NULL)->get();
            return view('pages.user.permissionedit')->with('permission', $permission)->with('employees', $employees)->with('user', $user);
        }else{
            return redirect()->route('home');
        }   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $request->validate([
            'employee_id' => 'required',
            'manager_id' => 'required',
        ]);
        $data = $request->all();
        $status = $permission->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'permission Updated Successfully !!');
        }else{
            request()->session()->flash('error', 'permission Not Updated !!');
        }
        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Permission::destroy($id);
        if($status){
            request()->session()->flash('success', 'Permission Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'Permission Not Deleted !!');
        }
        return redirect()->back();
    }
}
