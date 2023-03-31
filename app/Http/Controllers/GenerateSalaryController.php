<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\LeaveStatus;
use PDF;
use App\Models\LeaveManagement;
use App\Models\Email;
use App\Models\GenrateSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\LeavesInMonth;

use App\Http\Controllers\UserPermissionController;
use Auth;
use DB;
class GenerateSalaryController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_permissions = (new UserPermissionController)->get_user_permissions(Auth()->user()->id);
        if( in_array('create_generate_salary', $user_permissions ) ){
            if(Auth()->user()->user_r == 1){
                $employees = Employee::where('deleted_date', NULL)->get();
            }else{
                $employees = DB::table('employees')
                ->select('*')
                ->join('permissions', 'employees.id', '=', 'permissions.employee_id')
                ->where('permissions.manager_id', Auth()->user()->id)
                ->get();
            }
            $emails = Email::where('deleted_date', NULL)->get();
            return view('pages.generate_salary.list')->with('employees', $employees)->with('emails', $emails);
        }else{
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     $request->validate([
            'employee_id' => 'required',
        ]);
        $time    = time();
        $year  = $request->year;
        $month = $request->month;
        $adjust_leave = !empty( $request->adjust_leave ) ? $request->adjust_leave : 3;
        $daysInMonth = cal_days_in_month(0, $month, $year);
        //current month first day
        $start_month_date = date('Y-m-d',strtotime( $year.'-'.$month.'-01' ));
        //current month last day
        $end_month_date = date('Y-m-d',strtotime( $year.'-'.$month.'-'.$daysInMonth ));
        $email_content = Email::where('id',$request->subject_id)->first();
        $employee_permanent_date = Employee::where('id',$request->employee_id)->pluck('permanent_date')->first();
        if( !empty( $employee_permanent_date ) && $employee_permanent_date <= $end_month_date && '0000-00-00' != $employee_permanent_date ){
            $this->calculate_el_cl($request->employee_id, $month, $year, $employee_permanent_date, $adjust_leave );
        }
        $employee = Employee::where('id',$request->employee_id)->with('designation_info')->with('department_info')->first();
        $leaves_start_month_date = $start_month_date > $employee->basic_salary_ed ? $start_month_date : $employee->basic_salary_ed;
        $leaves = LeaveManagement::where( 'employee_id', $request->employee_id)->with('leave_info')->where('leave_date', '>=', $leaves_start_month_date )->where('leave_date', '<=', $end_month_date )->get();
        $basic_salary = $employee->basic_salary;
        $earn_leave = $employee->earn_leave;
        $casual_leave = $employee->casual_leave;
        $days_between = 0;
        if( !empty($employee->basic_salary_ed) && $employee->basic_salary_ed > $start_month_date ){
            $days_between = ceil(abs(strtotime($employee->basic_salary_ed) - strtotime($start_month_date)) / 86400);
        }
        $one_day_salary = $basic_salary/30;
        $total_leaves = $overtime = $total_deductions = 0;
        $leaves_dates = array();
        if(!empty($leaves)){
            foreach($leaves as $leave){
                if( 0 < $leave->leave_info->value ){
                    $overtime = $overtime + ( $leave->leave_info->value * $one_day_salary );
                }else{
                    $leaves_dates[ $leave->leave_info->name ][] = $leave->leave_date;
                    $total_leaves = $total_leaves + $leave->leave_info->value;
                }
            }
        }
        if( empty( $employee_permanent_date ) || $employee_permanent_date >= $end_month_date ){
            $employee->earn_leave = 0;
            $employee->casual_leave = 0;
        }

        $leaves_in_month = LeavesInMonth::where( 'employee_id', $request->employee_id)->where( 'm_y', date('m-Y' ,strtotime( $start_month_date ) ) )->pluck('leaves')->first();
        if( !empty( $leaves_in_month ) ){
            $total_available_paid_leave = $total_leaves - $leaves_in_month;
        }else{
            $total_available_paid_leave = $total_leaves;
        }
        if( 0 > $total_available_paid_leave ){
            $total_deductions = $one_day_salary*$total_available_paid_leave;
        }
        $final_salary = $basic_salary + $total_deductions + $overtime - $days_between*$one_day_salary;
        $no = floor($final_salary);
        $point = round($final_salary - $no, 2) * 100; //
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $final_salary_str = array();
        $words = array('0' => '', '1' => 'One', '2' => 'Two',
            '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
            '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
            '13' => 'Thirteen', '14' => 'Fourteen',
            '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
            '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
            '30' => 'Thirty', '40' => 'Torty', '50' => 'Fifty',
            '60' => 'Sixty', '70' => 'Seventy',
            '80' => 'Eighty', '90' => 'Ninety');
            $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $pay_number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($pay_number) {
                $plural = (($counter = count($final_salary_str)) && $pay_number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $final_salary_str[0]) ? ' and ' : null;
                $final_salary_str [] = ($pay_number < 21) ? $words[$pay_number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($pay_number / 10) * 10]
                    . " " . $words[$pay_number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $final_salary_str[] = null;
        }
        $final_salary_str = array_reverse($final_salary_str);
        $rupees = implode('', $final_salary_str);
        $paise = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';
        $amount_string = $rupees . "Rupees  ";
        $amount_string .= $paise > 0 ? $paise . " Paise" : "";
        $pdf = PDF::loadview('pages.generate_salary.salary', compact('month', 'year', 'final_salary', 'amount_string', 'start_month_date', 'end_month_date','employee', 'leaves', 'overtime', 'total_deductions', 'leaves_dates', 'leaves_in_month'))->setOptions(['defaultFont' => 'sans-serif']);
        $output = $pdf->output();
        $file_name = str_replace( " " , "-", $employee->name ).'-'.$start_month_date.'-salary.pdf';
        \Storage::disk('local')->put('/salary/'.$file_name, $output);
        if($request->email){
            $request->validate([
                'subject_id' => 'required',
            ]);
            $storagePath  = \Storage::disk('local')->path('salary/'.$file_name);
            $email_content->content = str_replace('%name%', $employee->name, $email_content->content);
            $email_content->content = str_replace('%month%', date('F', mktime(0, 0, 0, $month, 1) ), $email_content->content);
            $email_content->content = str_replace('%year%', $year, $email_content->content);
            $email_content->content = str_replace('%basic_salary%', $basic_salary, $email_content->content);
            $email_content->content = str_replace('%final_salary%', $final_salary, $email_content->content);
            $email_content->subject = str_replace('%name%', $employee->name, $email_content->subject);
            $email_content->subject = str_replace('%month%', date('F', mktime(0, 0, 0, $month, 1) ), $email_content->subject);
            Mail::send('emails.salary', ['user' => $employee, 'path' => $storagePath, 'email_content' => $email_content ], function ($mail) use ($employee, $storagePath, $email_content) {
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function emailToAll(Request $request){
        $request->validate([
            'employee_id' => 'required',
        ]);
        $time    = time();
        $emails = $fail_emails = "";
        $year  = $request->year;
        $month = $request->month;
        $daysInMonth = cal_days_in_month(0, $month, $year);
        //current month first day
        $start_month_date = date('Y-m-d',strtotime( $year.'-'.$month.'-01' ));
        //current month last day
        $end_month_date = date('Y-m-d',strtotime( $year.'-'.$month.'-'.$daysInMonth ));
        $email_content = Email::where('id',$request->subject_id)->first();
        $ids = $request->employee_id;
        foreach( $ids as $id ):

            $employee_permanent_date = Employee::where('id',$request->employee_id)->pluck('permanent_date')->first();
            if( !empty( $employee_permanent_date ) && $employee_permanent_date <= $end_month_date && '0000-00-00' != $employee_permanent_date ){
                $this->calculate_el_cl($request->employee_id, $month, $year, $employee_permanent_date);
            }
            $employee = Employee::where('id',$request->employee_id)->with('designation_info')->with('department_info')->first();
            $leaves_start_month_date = $start_month_date > $employee->basic_salary_ed ? $start_month_date : $employee->basic_salary_ed;
            $leaves = LeaveManagement::where( 'employee_id', $request->employee_id)->with('leave_info')->where('leave_date', '>=', $leaves_start_month_date )->where('leave_date', '<=', $end_month_date )->get();
            $basic_salary = $employee->basic_salary;
            $earn_leave = $employee->earn_leave;
            $casual_leave = $employee->casual_leave;
            $days_between = 0;
            if( !empty($employee->basic_salary_ed) && $employee->basic_salary_ed > $start_month_date ){
                $days_between = ceil(abs(strtotime($employee->basic_salary_ed) - strtotime($start_month_date)) / 86400);
            }
            $one_day_salary = $basic_salary/30;
            $total_leaves = $overtime = $total_deductions = 0;
            $leaves_dates = array();
            if(!empty($leaves)){
                foreach($leaves as $leave){
                    if( 0 < $leave->leave_info->value ){
                        $overtime = $overtime + ( $leave->leave_info->value * $one_day_salary );
                    }else{
                        $leaves_dates[ $leave->leave_info->name ][] = $leave->leave_date;
                        $total_leaves = $total_leaves + $leave->leave_info->value;
                    }
                }
            }
            if( empty( $employee_permanent_date ) || $employee_permanent_date >= $end_month_date ){
                $employee->earn_leave = 0;
                $employee->casual_leave = 0;
            }

            $leaves_in_month = LeavesInMonth::where( 'employee_id', $request->employee_id)->where( 'm_y', date('m-Y' ,strtotime( $start_month_date ) ) )->pluck('leaves')->first();
            if( !empty( $leaves_in_month ) ){
                $total_available_paid_leave = $total_leaves - $leaves_in_month;
            }else{
                $total_available_paid_leave = $total_leaves;
            }
            if( 0 > $total_available_paid_leave ){
                $total_deductions = $one_day_salary*$total_available_paid_leave;
            }
            $final_salary = $basic_salary + $total_deductions + $overtime - $days_between*$one_day_salary;
            $no = floor($final_salary); //2800
            $point = round($final_salary - $no, 2) * 100; //
            $hundred = null;
            $digits_1 = strlen($no); //4
            $i = 0;
            $final_salary_str = array();
            $words = array('0' => '', '1' => 'One', '2' => 'Two',
            '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
            '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
            '13' => 'Thirteen', '14' => 'Fourteen',
            '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
            '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
            '30' => 'Thirty', '40' => 'Torty', '50' => 'Fifty',
            '60' => 'Sixty', '70' => 'Seventy',
            '80' => 'Eighty', '90' => 'Ninety');
            $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
            while ($i < $digits_1) { // 0<4 true
                $divider = ($i == 2) ? 10 : 100; // false 100
                $pay_number = floor($no % $divider); //
                $no = floor($no / $divider);
                $i += ($divider == 10) ? 1 : 2;
                if ($pay_number) {
                    $plural = (($counter = count($final_salary_str)) && $pay_number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $final_salary_str[0]) ? ' and ' : null;
                    $final_salary_str [] = ($pay_number < 21) ? $words[$pay_number] .
                        " " . $digits[$counter] . $plural . " " . $hundred
                        :
                        $words[floor($pay_number / 10) * 10]
                        . " " . $words[$pay_number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
                } else $final_salary_str[] = null;
            }
            $final_salary_str = array_reverse($final_salary_str);
            $rupees = implode('', $final_salary_str);
            $paise = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';
            $amount_string = $rupees . "Rupees  ";
            $amount_string .= $paise > 0 ? $paise . " Paise" : "";
            $pdf = PDF::loadview('pages.generate_salary.salary', compact('month', 'year', 'final_salary', 'amount_string', 'start_month_date', 'end_month_date','employee', 'leaves', 'overtime', 'total_deductions', 'leaves_dates', 'leaves_in_month'))->setOptions(['defaultFont' => 'sans-serif']);
            $output = $pdf->output();
            $file_name = str_replace( " " , "-", $employee->name ).'-'.$start_month_date.'-salary.pdf';
            \Storage::disk('local')->put('/salary/'.$file_name, $output);
            $storagePath  = \Storage::disk('local')->path('salary/'.$file_name);
            $email_content->content = str_replace('{{name}}', $employee->name, $email_content->content);
            $email_content->content = str_replace('{{month}}', date('F', mktime(0, 0, 0, $month, 1) ), $email_content->content);
            $email_content->content = str_replace('{{year}}', $year, $email_content->content);
            $email_content->content = str_replace('{{basic_salary}}', $basic_salary, $email_content->content);
            $email_content->content = str_replace('{{final_salary}}', $final_salary, $email_content->content);
            $email_content->subject = str_replace('{{name}}', $employee->name, $email_content->subject);
            $email_content->subject = str_replace('{{month}}', date('F', mktime(0, 0, 0, $month, 1) ), $email_content->subject);
            $status = Mail::send('emails.salary', ['user' => $employee, 'path' => $storagePath, 'email_content' => $email_content ], function ($mail) use ($employee, $storagePath, $email_content) {
                $mail->from($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
                $mail->to($employee->email_id, $employee->name)->subject($email_content->subject);
                $mail->attach($storagePath);
            });
            if($status){
                $emails .= $employee->email_id.",";
            }else{
                $fail_emails .= $employee->email_id.",";
            }
        endforeach;
        if( $emails ){
            echo "Mail Sended Successfully! ".$emails;
        }
        if( $fail_emails ){
            echo "Mail failed! ".$emails;
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GenrateSalary  $genrateSalary
     * @return \Illuminate\Http\Response
     */
    public function show($employee_id)
    {
       //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GenrateSalary  $genrateSalary
     * @return \Illuminate\Http\Response
     */
    public function edit(GenrateSalary $genrateSalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GenrateSalary  $genrateSalary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GenrateSalary $genrateSalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GenrateSalary  $genrateSalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(GenrateSalary $genrateSalary)
    {
        //
    }

    /**
     * Calculate EL CL.
     *
     * @param  Employee id $employee_id
     * @return EL CL
     */
    public function calculate_el_cl($employee_id, $month, $year, $permanent_date, $adjust_leave )
    {
        $daysInMonth = cal_days_in_month(0, $month, $year);
        //current month last day
        $m_y = date('m-Y',strtotime( $year.'-'.$month.'-01' ));
        $end_month_date = date('Y-m-d',strtotime( $year.'-'.$month.'-'.$daysInMonth ));
        $start_month_date = date('Y-m-d',strtotime( $year.'-'.$month.'-01' ));
        $leaves_start_date = $permanent_date > $start_month_date ? $permanent_date : $start_month_date;
        $employee = Employee::where('id',$employee_id)->first();
        $old_leaves_in_month = LeavesInMonth::where('m_y', $m_y)->where('employee_id', $employee_id)->first();
        $leaves = LeaveManagement::where( 'employee_id', $employee_id)->where( 'deleted_date', null)->with('leave_info')->where('leave_date', '<=', $end_month_date )->where('leave_date', '>=', $leaves_start_date )->get();
        $total_leaves = $pending_leaves = 0;
        if( $leaves ):
            foreach( $leaves as $leave ):
                if( 0 > $leave->leave_info->value ){
                    $total_leaves = $total_leaves + $leave->leave_info->value;
                }
            endforeach;
        endif;
        if( $old_leaves_in_month ){
            if( ( $employee->casual_leave + $employee->earn_leave - $old_leaves_in_month->leaves ) < $adjust_leave ){
                $adjust_leave = $employee->casual_leave + $employee->earn_leave - $old_leaves_in_month->leaves;
                $dataemp = array('casual_leave'=> 0, 'earn_leave'=> 0);
                $employee->fill($dataemp)->save();
            }else{
                $total_leaves_p = $total_leaves > -$adjust_leave ? $total_leaves : -$adjust_leave;
                $pending_leaves = $total_leaves_p - $old_leaves_in_month->leaves;
            }
            $total_leaves = $total_leaves > -$adjust_leave ? $total_leaves : -$adjust_leave;
            $old_leaves_in_month_data = array('leaves' => $total_leaves);
            $old_leaves_in_month->fill($old_leaves_in_month_data)->save();
        }else{
            if( ( $employee->casual_leave + $employee->earn_leave ) < $adjust_leave ){
                $adjust_leave = $employee->casual_leave + $employee->earn_leave;
                $dataemp = array('casual_leave'=> 0, 'earn_leave'=> 0);
                $employee->fill($dataemp)->save();
                $pending_leaves = 0;
            }else{
                $pending_leaves = $total_leaves = $total_leaves > -$adjust_leave ? $total_leaves : -$adjust_leave;
            }
            $total_leaves = $total_leaves > -$adjust_leave ? $total_leaves : -$adjust_leave;
            $data = array('employee_id'=>$employee_id, 'm_y' => $m_y, 'leaves' => $total_leaves);
            LeavesInMonth::create($data);
        }
        if( 0 < $pending_leaves ){
            $employee->earn_leave = $employee->earn_leave + $pending_leaves;
            $dataemp = array('earn_leave'=> $employee->earn_leave);
            $employee->fill($dataemp)->save();
        }elseif( 0 > $pending_leaves){
            if( ( $employee->casual_leave - 1 ) >= 0 ){
                $employee->casual_leave = $employee->casual_leave - 1;
                $pending_leaves = $pending_leaves + 1;
            }
            if( $pending_leaves < 0 ){
                if( ( $employee->earn_leave + $pending_leaves ) >= 0 ){
                    $employee->earn_leave = $employee->earn_leave + $pending_leaves;
                    $pending_leaves = 0;
                }else{
                    $pending_leaves = $pending_leaves + $employee->earn_leave;
                    $employee->earn_leave = 0;
                }
            }
            if( $pending_leaves < 0 ){
                if( ( $employee->casual_leave + $pending_leaves ) >= 0 ){
                    $employee->casual_leave = $employee->casual_leave + $pending_leaves;
                }else{
                    $employee->casual_leave = 0;
                }
            }
            $dataemp = array('casual_leave'=> $employee->casual_leave, 'earn_leave'=> $employee->earn_leave);
            $employee->fill($dataemp)->save();
        }
    }

}

