<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Salary {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{$year}}</title>
   </head>
   <body>
      <div class="container" style= "max-width: 1024;">
         <table border="0" cellpadding="5" cellspacing="0" style = "width:1000 display: flex;">
            <tr>
               <td valign="top" width="70%">
                  <table >
                     <tr>
                        <td>
                           <table width="100%" align="left" >
                              <tr>
                                 <th>
                                    <h4>Salary statement for the month of {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{$year}}</h4>
                                 </th>
                              </tr>
                           </table>
                           <table style="margin-top: 15px; width: 100%;" >
                              <thead style="background: #808080; padding: 6px 0;color: #fff; ">
                                 <tr>
                                    <td colspan="2"></td>
                                 </tr>
                                 <tr>
                                    <th colspan="2" bgcolor="#000" >
                                       Date: <b>{{$start_month_date < $employee->basic_salary_ed ? $employee->basic_salary_ed : $start_month_date }}</b>
                                    </th>
                                 </tr>
                                 <tr>
                                    <td colspan="2"></td>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr align="left">
                                    <td>Emp Name</td>
                                    <td>{{$employee->name}}</td>
                                 </tr>
                                 <tr align="left">
                                    <td>Designation</td>
                                    <td>{{$employee->designation_info->name}}</td>
                                 </tr>
                                 <tr align="left">
                                    <td>Department </td>
                                    <td>{{$employee->department_info->department_name}}</td>
                                 </tr>
                                 <tr align="left">
                                    <td>Email Id</td>
                                    <td>{{$employee->email_id}}</td>
                                 </tr>
                                 <tr align="left">
                                    <td>PAN</td>
                                    <td>{{$employee->pan_number}}</td>
                                 </tr>
                              </tbody>
                           </table>
                           <table style="margin-top: 15px; width: 100%;">
                              <thead style="background: #808080; padding: 6px 0;color: #fff; ">
                                 <tr>
                                    <td colspan="2"></td>
                                 </tr>
                                 <tr>
                                    <th colspan="2" bgcolor="grey" color="#fff">Earning</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr align="left">
                                    <td>Period</td>
                                    <td>{{$start_month_date < $employee->basic_salary_ed ? $employee->basic_salary_ed : $start_month_date}} to {{$end_month_date}}</td>
                                 </tr>
                                 <tr align="left">
                                    <td>Basic </td>
                                    <td>{{$employee->basic_salary}}</td>
                                 </tr>
                                 <tr align="left">
                                    <td>Overtime</td>
                                    <td>{{ round( $overtime, 2) }} </td>
                                 </tr>
                                @if($overtime)
                                 <tr align="left">
                                     <td>Overtime Dates</td>
                                     <td>
                                     @foreach($leaves as $leave)
                                         @if( 0 < $leave->leave_info->value )
                                            {{date('d' ,strtotime($leave->leave_date) )}},
                                        @endif
                                     @endforeach
                                     </td>
                                 </tr>
                                @endif
                                 <tr align="left">
                                    <td>Incentive </td>
                                    <td>0</td>
                                 </tr>
                                 <tr align="left">
                                    <td>TA</td>
                                    <td>NA</td>
                                 </tr>
                                 <tr align="left">
                                    <td>DA</td>
                                    <td>NA</td>
                                 </tr>
                                 <tr align="left">
                                    <td>HRA</td>
                                    <td>NA</td>
                                 </tr>
                              </tbody>
                           </table>
                           <table style="margin-top: 15px; width: 100%;" >
                              <thead style="background: #808080; padding: 6px 0;color: #fff; ">
                                 <tr>
                                    <td colspan="2"></td>
                                 </tr>
                                 <tr>
                                    <th colspan="2" >Adjustments</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr align="left">
                                    <td>EL</td>
                                    <td>{{$employee->earn_leave}}</td>
                                 </tr>
                                 <tr align="left">
                                    <td>CL</td>
                                    <td>{{$employee->casual_leave}}</td>
                                 </tr>
                              </tbody>
                           </table>
                           <table style="margin-top: 15px; width: 100%;" >
                              <thead style="background: #808080; padding: 6px 0;color: #fff; ">
                                 <tr>
                                    <td colspan="2"></td>
                                 </tr>
                                 <tr>
                                    <th colspan="2" bgcolor="grey" color="#fff">Deductions</th>
                                 </tr>
                              </thead>
                              <tbody>
                                  @if($leaves_dates)
                                    @foreach($leaves_dates as $key => $value )
                                        <tr align="left">
                                            <td>{{$key}} Dates</td>
                                            <td>
                                                @foreach($value as $date )
                                                    {{date('d' ,strtotime($date) )}},
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                 @endif
                                 <tr align="left">
                                    <td>Total Leave Adjusted</td>
                                    <td>{{abs( $leaves_in_month )}}</td>
                                 </tr>
                                 <tr align="left">
                                    <td>Advance</td>
                                    <td>0</td>
                                 </tr>
                                 <tr align="left">
                                    <td>Total deductions</td>
                                    <td>{{round($total_deductions)}}</td>
                                 </tr>
                              </tbody>
                           </table>
                           <table style="margin-top: 15px; width: 100%;" >
                              <thead style="background: #808080; padding: 6px 0;color: #fff; ">
                                 <tr>
                                    <th colspan="2" bgcolor="grey" color="#fff">Net Salary : {{round($final_salary)}}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr align="left">
                                    <td>Net Payable</td>
                                    <td style="background: #ff0" bgcolor="yellow">{{round($final_salary)}}</td>
                                 </tr>
                                 <tr align="left">
                                    <td colspan="2">Amount in words: {{$amount_string}} Only</td>
                                 </tr>
                              </tbody>
                           </table>
                           <table width="100%">
                              <tr>
                                 <td></td>
                              </tr>
                              <tr>
                                 <td align="left"><br/><br/><br/><br/><small><b>Please note that this is a system generated statement and does not require signature.</b><br/><br/><small><i>This document is confidential. It is intended solely for the addressees. If you are not an intended recipient, any use, copy or diffusion, even partial of this message
                                    is prohibited. Please delete it and notify the sender immediately. Since the integrity of this message cannot be guaranteed on the Internet, ABS Group of Companies cannot
                                    therefore be considered liable for its content<small><i></small>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
               <td valign="top"style="width: 10%; padding: 0px 17px; border-left: 4px solid #b33292; background: #e6e7e9">
                  <img width="170px;" src="data:image/png;base64,{{ base64_encode( file_get_contents( storage_path('/app/public/files/1/contect-img.jpg') ))}}">
               </td>
            </tr>
         </table>
      </div>
   </body>
</html>