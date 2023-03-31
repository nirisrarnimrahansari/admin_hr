@extends('layouts.app', ['activePage' => 'employee-view', 'titlePage' => __('')])
@section('content')

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __(' Employee View Page') }}</h4>
                    <p class="card-description">View Employee Details</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead  class="text-primary"><div class="card ml-auto mr-auto " style="max-width:65rem;" >
                                <tr>
                                    <!-- <th  style="font-size: 17px;"> </th>
                                    <th  style="font-size: 17px;"></th> -->
                                </tr> 
                            </thead>       
                            <tbody> 
                                <tr>
                                    <td style="font-size: 17px;" >Employee Id</td>
                                    <td style="font-size: 15px;">{{ $employee->id }}</td>
                                </tr>
                                <tr >  
                                    <td style="font-size: 17px;">Employee Name</td> 
                                    <td style="font-size: 15px;">{{ $employee->name }}</td> 
                                </tr> 
                                <tr>  
                                <td style="font-size: 17px;">Employee Father Name</td>  
                                <td style="font-size: 15px;">{{ $employee->father_name }}</td>
                                </tr>  
                                <tr>  
                                <td style="font-size: 17px;">Employee Select ID</td> 
                                <td style="font-size: 15px;">{{ $employee->select_id }}</td> 
                                </tr>
                                <tr>  
                                <td style="font-size: 17px;">Employee  ID Proof Image</td>                                                                                     
                                <td>
                                    <img width="33%" height="33%" src="{{ $employee['id_proof'] }}">
                                </td> 
                                </tr>  
                                <tr>  
                                <td style="font-size: 17px;" >Employee Pan Card Image</td>  
                                <td><img width="33%" height="33%" src="{{ $employee['upload_pan_card'] }}"></td>
                                </tr>  
                                <tr>  
                                <td style="font-size: 17px;">Employee Pan Number</td>
                                <td style="font-size: 15px;">{{ $employee->pan_number }}</td>  
                                </tr>      
                                <tr>  
                                <td style="font-size: 17px;">Employee Designation</td> 
                                <td style="font-size: 15px;">{{ $employee->designation_info['name'] }}</td> 
                                </tr>  
                                <tr>  
                                <td style="font-size: 17px;">Employee Email ID</td> 
                                <td style="font-size: 15px;">{{ $employee->email_id }}</td> 
                                </tr>
                                <tr>  
                                <td style="font-size: 17px;">Employee Whats'app Number</td> 
                                <td style="font-size: 15px;">{{ $employee->whatsapp_no }}</td> 
                                </tr>  
                                <tr>  
                                <td style="font-size: 17px;">Employee Date Of Birth</td> 
                                <td style="font-size: 15px;">{{ $employee->dob }}</td> 
                                </tr>
                                <tr>  
                                <td style="font-size: 17px;">Employee Joinnig Date</td>  
                                <td style="font-size: 15px;">{{ $employee->joining_date }}</td>
                                </tr>
                                <tr>  
                                <td style="font-size: 17px;">Employee Basic Salary</td>  
                                <td style="font-size: 15px;">{{ $employee->basic_salary }}</td>
                                </tr>  
                                <tr>  
                                <td style="font-size: 17px;">Employee Basic Salary Effective Date</td>  
                                <td style="font-size: 15px;">{{ $employee->basic_salary_ed }}</td>
                                </tr> 
                                <tr>  
                                <td style="font-size: 17px;">Employee Shift</td> 
                                <td style="font-size: 15px;">{{ $employee->shift_info['name'] }}</td> 
                                </tr>  
                                <tr>  
                                <td style="font-size: 17px;">Employee Shift Effective Date</td> 
                                <td style="font-size: 15px;">{{ $employee->shift_ed }}</td> 
                                </tr>
                                <tr>  
                                <td style="font-size: 17px;">Employee Type</td> 
                                <td style="font-size: 15px;">{{ $employee->type }}</td> 
                                </tr>  
                                <tr>  
                                <td style="font-size: 17px;">Employee Permanent Date</td> 
                                <td style="font-size: 15px;">{{ $employee->permanent_date }}</td> 
                                </tr>  
                                <tr>  
                                <td style="font-size: 17px;">Employee Casual Leaves</td> 
                                <td style="font-size: 15px;">{{ $employee->casual_leave }}</td> 
                                </tr> 
                                <tr>  
                                <td style="font-size: 17px;">Employee Earn Leaves</td> 
                                <td style="font-size: 15px;">{{ $employee->earn_leave }}</td> 
                                </tr> 
                                <tr>  
                                <td style="font-size: 17px;">Employee Department</td>  
                                <td style="font-size: 15px;">{{ $employee->department_info['department_name'] }}</td> 
                                </tr> 
                                <tr>  
                                <td style="font-size: 17px;">Employee Biometric ID </td>  
                                <td style="font-size: 15px;">{{ $employee->biometric_id }}</td>
                                </tr>  
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group col-lg-6 mb-3 ml-3">
                    <a type="button" href="/employee" class="btn btn-primary mb-3">Go back</a>
                </div>
            </div>
        </div>   
    </div>   
</div>   
@endsection