<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use App\Http\Controllers\UserPermissionController;
use Auth;

class UserRoleController extends Controller
{
  
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_permission = UserPermission::where('deleted_date', NULL)->get();
        $user_role = UserRole::where('deleted_date', NULL)->get();
        return view('pages.user_role.list')->with('user_role', $user_role)->with('user_permission', $user_permission);
    
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
            'user_name' => 'required',
            'user_permission' => 'nullable',
        ]);
        $data = $request->all();
    
        if(isset($data['user_permission'])){
            $data['user_permission'] = json_encode($data['user_permission']);
        }
        $status = UserRole::create($data);
        if($status){
            request()->session()->flash('success', 'User Role Name Created Successfully !!');
        }else{
            request()->session()->flash('error', 'User Role Name not created !!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {}
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_user_role', $user_permissions ) ){
            $user_role = UserRole::findOrFail($id);
            $user_permission = UserPermission::where('deleted_date', NULL)->get();
            return view('pages.user_role.edit')->with('user_permission', $user_permission)->with('user_role', $user_role);
        }else{
            return redirect()->route('home');
        }
        }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_role = UserRole::findOrFail($id);
        $request->validate([
            'user_name' => 'required',
            'user_permission' => 'nullable',
        ]);
        $data = $request->all();
        $data['user_permission'] = json_encode($data['user_permission']);
        $status = $user_role->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'User Role Updated Successfully !!');
        }else{
            request()->session()->flash('error', 'User Role Not Updated !!');
        }
        return redirect()->route('user-role.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = UserRole::destroy($id);
        if($status){
            request()->session()->flash('success', 'User Role Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'User Role Not Deleted !!');
        }
        return redirect()->back();
    }
    

}