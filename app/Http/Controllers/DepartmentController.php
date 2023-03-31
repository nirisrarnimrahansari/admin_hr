<?php

namespace App\Http\Controllers;
use App\Models\UserPermission;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Exports\DepartmentExport;  
use App\Imports\DepartmentImport;  
use Maatwebsite\Excel\Facades\Excel;  
use App\Http\Controllers\UserPermissionController;
use Auth;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //  $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        //  if( in_array('create_department', $user_permissions ) ){
            $department = Department::where('deleted_date', NULL)->get();
            return view('pages.department.list')->with('department', $department);
        //  }else{
        //     return redirect()->route('home');
        //  }
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
            'department_name' => 'required',
        ]);
        $data = $request->all();
        $status = Department::create($data);
        if($status){
            request()->session()->flash('success', 'Department Created Successfully !!');
        }else{
            request()->session()->flash('error', 'Department not created !!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
    if( in_array('update_department', $user_permissions ) ){
        $department = Department::findOrFail($id);
            return view('pages.department.edit')->with('department', $department);
        }else{
            return redirect()->route('home');
        } 

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $department = Department::findOrFail($id);
        $request->validate([
            'department_name' => 'required',
        ]);
        $data = $request->all();
        $status = $department->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'Department updated Successfully !!');
        }else{
            request()->session()->flash('error', 'Department not updated !!');
        }
        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Department::destroy($id);
        if($status){
            request()->session()->flash('success', 'Department Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'Department not deleted !!');
        }
        return redirect()->back();
    }
    
 }