<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\UserRole;
use App\Models\Designation;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UserPermissionController;
use Auth;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(){
        $user_role = UserRole::where('deleted_date', NULL)->get();
        $designation = Designation::where('deleted_date', NULL)->get();
        $user = User::with('role_info')->with('designation_info')->where('deleted_date', NULL)->get();
        return view('pages.user.add')->with('user', $user)->with('designation', $designation)->with('user_role', $user_role);
    } 
 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $user = User::where('deleted_date', NULL)->get();
        $employees = Employee::where('deleted_date', NULL)->get();
        return view('pages.user.permission')->with('employees', $employees)->with('user', $user);
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
        'email'=> 'required|email|unique:users', 
        'password'=> 'required',
        'mobile' => 'required|digits:10|unique:users',
        'user_r' => 'required',
        'user_occ' => 'required',
        'user_image' => 'required',
        ]);
        $data = $request->all();
        $data['password'] = Hash::make( $data['password'] );
        $status = User::create($data);
        if($status){
            request()->session()->flash('success', 'User Created Successfully !!');
        }else{
            request()->session()->flash('error', 'User Not Created !!');
        }
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_user', $user_permissions ) ){
            $user = User::findOrFail($id);
            $user_role = UserRole::where('deleted_date', NULL)->get();
            $designation = Designation::where('deleted_date', NULL)->get();
            return view('pages.user.edit')->with('user', $user)->with('designation', $designation)->with('user_role', $user_role);
        }else{
            return redirect()->route('home');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email'=> 'required|email', 
            'password'=> 'required',
            'mobile' => 'required|digits:10',
            'user_r' => 'required',
            'user_occ' => 'required',
            'user_image' => 'required',
            ]);
            $data = $request->all();
            $data['password'] = Hash::make( $data['password'] );
            $status = $user->fill($data)->save();
            if($status){
                request()->session()->flash('success', 'user Updated Successfully !!');
            }else{
                request()->session()->flash('error', 'user Not Updated !!');
            }
            return redirect()->route('user.index');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = User::destroy($id);
        if($status){
            request()->session()->flash('success', 'User Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'User Not Deleted !!');
        }
        return redirect()->back();
    }
}
