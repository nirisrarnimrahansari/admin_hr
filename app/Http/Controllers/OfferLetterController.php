<?php 
 
namespace App\Http\Controllers;
 
use App\Models\OfferLetter;
use Illuminate\Http\Request;

use App\Http\Controllers\UserPermissionController;
use Auth;
class OfferLetterController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offer_letters = OfferLetter::where('deleted_date', NULL)->get();
        return view('pages.generate_salary.offer_letter')->with('offer_letters',$offer_letters);
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
            'description' => 'required',
            'content' => 'required',
        ]);
        $data = $request->all();
        
        $status = OfferLetter::create($data);
        if($status){
            request()->session()->flash('success', 'Offer Letter Form Created Successfully !!');
        }else{
            request()->session()->flash('error', 'Offer Letter Form not created !!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfferLetter  $offerLetter
     * @return \Illuminate\Http\Response
     */
    public function show(OfferLetter $offerLetter)
    {
        //
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfferLetter  $offerLetter
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_offer_letter', $user_permissions ) ){
             $offer_letters = OfferLetter::findOrFail($id);
        return view('pages.generate_salary.offer_later_edit')->with('offer_letters',$offer_letters);
        }else{
            return redirect()->route('home');

        }     
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfferLetter  $offerLetter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $offer_letters = OfferLetter::findOrFail($id);
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
            'content' => 'required',
        ]);
        $data = $request->all();
        $status = $offer_letters->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'Offer Letter Form updated Successfully !!');
        }else{
            request()->session()->flash('error', 'Offer Letter Form not updated !!');
        }
        return redirect()->route('offer-letter.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfferLetter  $offerLetter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = OfferLetter::destroy($id);
        if($status){
            request()->session()->flash('success', 'Offer Letter Form Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'Offer Letter Form Not Deleted !!');
        }
        return redirect()->back();
    }
}
