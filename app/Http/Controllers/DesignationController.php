<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\UserPermissionController;
use Auth;
class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function index()
    {
        $designation = Designation::where('deleted_date', NULL)->get();
        return view('pages.designation.list')->with('designation', $designation);
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
        ]);
        $data = $request->all();
        $status = Designation::create($data);
        if($status){
            request()->session()->flash('success', 'Designation Created Successfully !!');
        }else{
            request()->session()->flash('error', 'Designation not created !!');
        }
        return redirect()->back();
    }
 
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Model\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Model\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_designation', $user_permissions ) ){
             $designation = Designation::findOrFail($id);
            return view('pages.designation.edit')->with('designation', $designation);
        }else{
            return redirect()->route('home');

        }     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Model\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $designation = Designation::findOrFail($id);
        $request->validate([
            'name' => 'required',
        ]);
        $data = $request->all();
        $status = $designation->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'Designation updated Successfully !!');
        }else{
            request()->session()->flash('error', 'Designation not updated !!');
        }
        return redirect()->route('designation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Model\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Designation::destroy($id);
        if($status){
            request()->session()->flash('success', 'Designation Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'Designation not deleted !!');
        }
        return redirect()->back();
    }
}
