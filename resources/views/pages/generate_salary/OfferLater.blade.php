<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Offer Later</title>
   </head>
   <body>
      <div class="container" style= "max-width: 1024px; ">
         <div style="display: inline-flex; justify-content: space-between; width:100%; margin-bottom:15px" >
               <div  style= "max-width: 400px;float:left;">
                  <img width="200px;" src="data:image/png;base64,{{ base64_encode( file_get_contents( storage_path('/app/public/files/1/absit_black_logo_.png') ))}}">
               </div>
               <div   style= "max-width: 1000px; float:left; margin-top:15px; margin-left:15px;">
                  <p> 
                     IIIrd Floor, Arcade Silver, Chappan, M.G. Road, Indore - 452001, (MP), INDIA<br>
                     Phone : +91 731 4044497, +91 731 2544539, fax: +91-731-4044497<br>
                     email : mail@abssoftech.com, web : www.abssoftech.com <br>
                  </p>
               </div>
         </div><br>
         <div style="width:100%; clear:both;">
              <h4> Dear Ms/Mrs/Miss. {{$employee->name}}:</h4>
               <p>
                  We are pleased to offer you appointment as <b>{{$employee->designation_info->name}}</b> which effects from  <b>{{date('d/m/y' ,strtotime($employee->joining_date) )}}</b> . In this
                  capacity, You will report to signatory of this letter. Your appointment is subject to the following terms &
                  conditions.
               </p>

               <h4>Your salary Package</h4>
               <p>
                  You are responsible for coding using PHP, SQL, Javascript , Pagebuilder & Bootstrap. You are given a basic
                  salary of Rs. <b>{{$employee->basic_salary}}/month</b>. No other considerations are part of your salary package.
               </p>

               <h4>Your Office timings</h4>
               <p>
                  You are required to come to office by <b>{{$employee->shift_info->login_time}} am</b>  sharply to <b>{{$employee->shift_info->logout_time}} pm</b>. If you come late by more than 10 min
                  without permission of the manager, then that day will be treated as a half day.
               </p>

               <h4>Leave</h4>
               <p>
                                
                  You will be entitled to earned leaves on Sundays only. Extra leaves and half days will deduct the amount from
                  your salary. While Leaves & Halfdays without approval from the manager, will be counted as unapproved leave
                  and will reflect in your monthly salary statement with double salary deduction.
               </p>

               <h4>  Probation Period</h4>
               <p>
                  You will be on probation for a period of 6 month from the date of joining. This period may be extended by
                  another 6 month if your manager feel that your performance is unsatisfactory. On completion of your probation
                  period you will receive a confirmation letter confirming your services in this company. At that time no salary
                  review will be done.
               </p>
               <h4>Salary Reviews</h4>
               <p>
                  Salaries are reviewed on completion of financial year. Employees who are still in their probation period will not
                  qualify for any salary review.
               </p>
               <h4>Termination</h4>
               <p>
                  Normal Termination by either party will be subject to one months written notice, or salary in lieu of other that
                  dismissal due to gross misconduct, in which case the matter will be dealt on the severity of the offence and
                  as the Management deem fit. If you resign without informing a month before, then the salary of the resigned
                  month will not be paid.
               </p>
               <h4>General Conditions</h4>
               <p>
                  As you are a dynamic and passionate personality, your job is full of opportunities to gain knowledge,
                  experience and expertise. You will be provided opportunities to experience different cultures, languages,
                  people and professional minds for that you will have to show your grit, guts & gumption. The line is equally
                  prospective from financial point of view as there is no bar as to how much you can earn. The net salary (totally
                  and wholly) depends on your performance. But even for your worst performance we are bound to pay you Rs.
                 <b> {{$employee->basic_salary}}-/</b>But your worst performance may hamper your continuation as a member of company
               </p>
               <h4>General Information</h4>
               <p>
                  We are a part of Architectural Industry ever since the start of our first company absIT in 2004,and share a
                  market with professional architectural products as Best of Architects, Updates of Best of Architects, 3D
                  Innovation, 3D Innovation IInd, Arch Studio, Beauteous, Rendering Engine and CadMAX Tutorial. Coming time
                  will bring more products for the architectural Industry.
                  Finding ourselves proficient for Architectural Industry with a very wide clientele in domestic and international
                  market, expert team of professionals in architectural designing, 3D rendering, structural engineering, interior
                  designing works, adequate infrastructure of computer systems and software’s; we believe to possess caliber to
                  give good service in this sector. Thus we have started DesignLAB International service specifically considering
                  the Architectural Professionals to give the resolution of all the shortfalls as analyzed by our expert team.
                  Through DesignLAB International we work on four areas of your benefits, with a pure motto of providing the
                  best and latest of design for our and your clients as well. DesignLAB International is working on following
                  segments.
                  Exterior, Interior, 3D Floor Planning, Structure Designing & Walkthrough Making.
               </p>
               <h4>Instructions</h4>
               <p>
                  Please sign the duplicate copy of this letter as a token of your acceptance of the offer letter and submit it to
                  the company. We welcome you to the Absit family and look forward to a long and mutually satisfying and
                  rewarding association.
               </p>
               <br>
            </div>
               <p>Yours very truly</p><br>
               <p>Anis Qureshi<br>
                  Managing Director<br>
                  ABS Softech Pvt. Ltd.
               </p>
               <br>
               <pre style="font-family: 'sans-serif'; text-align: center;">
                  I accept the terms of appointment and the offer is accepted by me.
               </pre>

               <p>Date :</p>                                  
               <p>Signature of the appointee :</p>                                  
   </div>
   </body>
</html>