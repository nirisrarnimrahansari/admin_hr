<?php

namespace App\Http\Controllers;

use App\Models\UserPermission;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\UserPermissionController;
use Auth;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_permission = UserPermission::where('deleted_date', NULL)->get();
        return view('pages.user_permission.list')->with('user_permission', $user_permission);
        
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
            'slug' => 'required',
        ]);
        $data = $request->all();
        $status = UserPermission::create($data);
        if($status){
            request()->session()->flash('success', 'User Permission Created Successfully!!');
        }else{
            request()->session()->flash('error', 'User Permission Denied');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserPermission  $userPermission
     * @return \Illuminate\Http\Response
     */
    public function show(UserPermission $userPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserPermission  $userPermission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_user_permission', $user_permissions ) ){
            $user_permission = UserPermission::findOrFail($id);
            return view('pages.user_permission.edit')->with('user_permission', $user_permission);
        }else{
            return redirect()->route('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPermission  $userPermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_permission = UserPermission::findOrFail($id);
        $request->validate([
            'name' =>'required',
            'slug' =>'required',
        ]);
        $data = $request->all();
        $status = $user_permission->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'User Permission Updated Successfully');
        }else{
            request()->session()->flash('error', 'User Permisssion Not Updated');
        }
        return redirect()->route('user-permission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPermission  $userPermission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = UserPermission::destroy($id);
        if($status){
            request()->session()->flash('success', 'User Permission Deleted Successfully');
        }else{
            request()->session()->flash('error', 'User Permission Not Deleted');
        }
        return redirect()->back();
    }

    /**
     * get all users permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public static function get_user_permissions($id)
    {
        $user = User::findOrFail($id);
        $user_permission_ids = UserRole::select('user_permission')->where('id', $user->user_r)->pluck('user_permission')->first();
        $user_permission_slug = UserPermission::select('slug')->whereIn('id', json_decode($user_permission_ids))->pluck('slug')->toArray();
        return $user_permission_slug;
    }

}
