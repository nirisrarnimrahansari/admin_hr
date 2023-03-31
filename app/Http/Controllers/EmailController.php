<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
          $email = Email::where('deleted_date', NULL)->get();
        return view('pages.generate_salary.email_format')->with('email', $email);
       
        Mail::to('nimrah271999@gmail.com')->send(new NotifyMail());
     
        if (Mail::failures()) {
             return response()->Fail('Sorry! Please try again latter');
        }else{
             return response()->success('Great! Successfully send in your mail');
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
            'subject' => 'required',
            'content' => 'required',
        ]);
        $data = $request->all();
        $status = Email::create($data);
        if($status){
            request()->session()->flash('success', 'Email save Successfully !!');
        }else{
            request()->session()->flash('error', 'email not save !!');
        }
        return redirect()->route('email-format.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_email_format', $user_permissions ) ){
            $email = Email::findOrFail($id);
            return view('pages.generate_salary.edit')->with('email', $email);
        }else{
            return redirect()->route('home');
        } 
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $email = Email::findOrFail($id);
        $request->validate([
            'subject' => 'required',
            'content' => 'required',
        ]);
        $data = $request->all();
        $status = $email->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'Email Format Data updated Successfully !!');
        }else{
            request()->session()->flash('error', 'Email Format Data not updated !!');
        }
        return redirect()->route('email-format.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Email::destroy($id);
        if($status){
            request()->session()->flash('success','Email Format Data Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'Email Format Data not deleted !!');
        }
        return redirect()->back();
    }
}
