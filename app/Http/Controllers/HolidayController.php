<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

use App\Http\Controllers\UserPermissionController;
use Auth;
class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holiday = Holiday::where('deleted_date', NULL)->get();
        return view('pages.holiday.list')->with('holiday', $holiday);
   
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
            'holiday_name' => 'required',
            'holiday_date' => 'required',
        ]);
        $data = $request->all();
        $status = Holiday::create($data);
        if($status){
            request()->session()->flash('success', 'Holiday Created Successfully !!');
        }else{
            request()->session()->flash('error', 'Holiday Not created !!');
        return redirect()->back();
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_holidays', $user_permissions ) ){
            $holiday = Holiday::findOrFail($id);
            return view('pages.holiday.edit')->with('holiday', $holiday);
        }else{
            return redirect()->route('home');
        }    
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $holiday = Holiday::findOrFail($id);
        $request->validate([
            'holiday_name' => 'required',
            'holiday_date' => 'required',
        ]);
        $data = $request->all();
        $status = $holiday->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'Holiday Updated Successfully !!');
        }else{
            request()->session()->flash('error', 'Holiday Not Updated !!');
        }
        return redirect()->route('holiday.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Holiday::destroy($id);
        if($status){
            request()->session()->flash('success', 'Holiday Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'Holiday Not Deleted !!');
        }
        return redirect()->back();
    }
}
