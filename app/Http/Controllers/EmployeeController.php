<?php

namespace App\Http\Controllers;
use App\Models\OfferLetter;
use App\Models\Employee;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Controllers\UserPermissionController;
use Auth;
use PDF;
use Illuminate\Support\Facades\Mail;
use DB;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $designation = Designation::where('deleted_date', NULL)->get();
        $OfferLetter = OfferLetter::where('deleted_date', NULL)->get();
        $department = Department::where('deleted_date', NULL)->get();
        $shift = Shift::where('deleted_date', NULL)->get();
        if(Auth()->user()->user_r == 1){
            $employees = Employee::where('deleted_date', NULL)->get();
        }else{
            $employees = DB::table('employees') 
            ->select('*')
            ->join('permissions', 'employees.id', '=', 'permissions.employee_id')
            ->where('permissions.manager_id', Auth()->user()->id)
            ->get();
        }
        return view('pages.employee.list')->with('employees', $employees)->with('department', $department)->with('shift', $shift)->with('designation', $designation)->with('OfferLetter', $OfferLetter);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designation = Designation::where('deleted_date', NULL)->get();
        $department = Department::where('deleted_date', NULL)->get();
        $shift = Shift::where('deleted_date', NULL)->get();
        return view('pages.employee.add')->with('designation', $designation)->with('department', $department)->with('shift', $shift);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function email(Request $request)
    {     
            $request->validate([
                'employee_id' => 'required',
            ]);
        $employee_id  = $request->employee_id;
        $designation  = $request->designation_id;
        $joining_date = $request->joining_date;
        $basic_salary = $request->basic_salary;
        $login_time = $request->login_time;
        $logout_time = $request->logout_time;
        $email_content = DB::table('offer_latters') 
            ->select('*')->first();
            // $email_content = OfferLetter::where('id',$request->id)->first();
        // print_r('<br>');
        // print_r($request->all());
        // print_r($email_content->subject);
        // die();
        $employee = Employee::where('id',$request->employee_id)->with('designation_info')->with('shift_info')->first();
        // $shift = Shift::where( 'employee_id', $request->employee_id)->with('shift_info')->get();
        $basic_salary = $employee->basic_salary;
        $employee_id  = $employee->employee_id;
        $designation  = $employee->designation_info['name'];
        $joining_date = date('d/m/y' ,strtotime($employee->joining_date) );
        $login_time =   $employee->shift_info['login_time'];
        $logout_time =   $employee->shift_info['logout_time'];
        $pdf = PDF::loadview('pages.generate_salary.OfferLater', compact('designation', 'joining_date', 'basic_salary', 'login_time', 'logout_time','employee'))->setOptions(['defaultFont' => 'sans-serif']);
        $output = $pdf->output();
        $file_name = str_replace( " " , "-", $employee->name ).'-'.'offerLater.pdf';
        \Storage::disk('local')->put('/OfferLater/'.$file_name, $output);
        if($email_content && !empty($request->email)){

            $storagePath  = \Storage::disk('local')->path('OfferLater/'.$file_name);
            $email_content->content = str_replace('%name%', $employee->name, $email_content->content);
            $email_content->content = str_replace('%designation%', $employee->designation_info['name'], $email_content->content);
            $email_content->content = str_replace('%joining_date%', $joining_date, $email_content->content);
            $email_content->content = str_replace('%basic_salary%', $basic_salary, $email_content->content);
            $email_content->content = str_replace('%login_time%', $login_time, $email_content->content);
            $email_content->content = str_replace('%logout_time%', $logout_time, $email_content->content);
            $email_content->subject = str_replace('%name%', $employee->name, $email_content->subject);
            Mail::send('emails.OfferLater', ['user' => $employee, 'path' => $storagePath, 'email_content' => $email_content ], function ($mail) use ($employee, $storagePath, $email_content) {
                $mail->from($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
                $mail->to($employee->email_id, $employee->name)->subject($email_content->subject);
                $mail->attach($storagePath);
                request()->session()->flash('success', 'Employee Email Send Successfully !!');
            });
        }
        if($request->download_pdf){
            request()->session()->flash('success', 'Employee Pdf Downloaded Successfully !!');
                return $pdf->download($file_name);

        }else{
            request()->session()->flash('success', 'Employee Data Send Successfully !!');
            return redirect()->back();

        }
    }
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'father_name'=> 'required', 
        'select_id'=> 'required',
        'id_proof' => 'required',
        'upload_pan_card' => 'required',
        'pan_number' => 'required|string',
        'designation_id' => 'required',
        'email_id' => 'required|email',
        'whatsapp_no' => 'required|digits:10',
        'dob' => 'required',
        'joining_date' => 'required',
        'basic_salary' => 'required|numeric',
        'shift_id' => 'required',
        'shift_ed' => 'required',
        'department_id' => 'required',
        'biometric_id' => 'required',
        'agreement_condition' => 'required',
         ]);

        $data = $request->all();
        $status = Employee::create($data);
        if($status){
            request()->session()->flash('success', 'Employee Created Successfully !!');
        }else{
            request()->session()->flash('error', 'Employee Not Created !!');
        }
        return redirect()->route('employee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('view_employee', $user_permissions ) ){
            $employee = Employee::with('designation_info')->with('shift_info')->with('department_info')->findOrFail($id);
            return view('pages.employee.view')->with('employee', $employee);
        }else{
            return redirect()->route('home');
        }    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('update_employee', $user_permissions ) ){
            $employees = Employee::where('deleted_date', NULL)->get();
            $employees = Employee::findOrFail($id);
            $designation = Designation::where('deleted_date', NULL)->get();
            $department = Department::where('deleted_date', NULL)->get();
            $shift = Shift::where('deleted_date', NULL)->get();
            return view('pages.employee.edit')->with('employees', $employees)->with('designation', $designation)->with('department', $department)->with('shift', $shift);
        }else{
            return redirect()->route('home');
        }
        }

    /**-manager
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $employees = Employee::findOrFail($id);
        $request->validate([
            'name' => 'required|min:2|max:255',
            'father_name'=> 'required|min:2|max:255', 
            'select_id'=> 'required',
            'id_proof' => 'required',
            'upload_pan_card' => 'required',
            'pan_number' => 'required|string',
            'designation_id' => 'required',
            'email_id' => 'required|email',
            'whatsapp_no' => 'required|digits:10',
            'dob' => 'required',
            'joining_date' => 'required',
            'basic_salary' => 'required|numeric',
            'shift_id' => 'required',
            'shift_ed' => 'required',
            'department_id' => 'required',
            'biometric_id' => 'required',
        ]);
        $data = $request->all();
        $status = $employees->fill($data)->save();
        if($status){
            request()->session()->flash('success', 'Employee Updated Successfully !!');
        }else{
            request()->session()->flash('error', 'Employee Not Updated !!');
        }
        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Employee::destroy($id);
        if($status){
            request()->session()->flash('success', 'Employee Deleted Successfully !!');
        }else{
            request()->session()->flash('error', 'Employee Not Deleted !!');
        }
        return redirect()->back();
    }
}
