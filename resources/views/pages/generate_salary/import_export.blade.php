@extends('layouts.app', ['activePage' => 'generate_salary-import_export', 'titlePage' => __('')])

@section('content') 
<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">{{ __('Import/Export Salary Of Employee') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="select_month"> Select Month</label>
                                <select class="form-control month_year" id="generate-salary-month">
                                    @for($m = 1; $m <= 12; $m++)
                                        <option {{ $month == $m ? "selected" : ""}} value="{{ route('import-export', [$m ,$year, $subject_id]) }}">{{ date('F', mktime(0, 0, 0, $m, 1)); }} ( {{$m}} )</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="select_year"> Select Year</label>
                                <select class="form-control month_year" id="generate-salary-year" >
                                    @for($y = date('Y', time() ); $y >= 2004; $y--)
                                        <option {{ $year == $y ? "selected" : ""}} value="{{ route('import-export', [$month ,$y, $subject_id]) }}">{{$y}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-lg-3">
                                    <label for="subject_id"> Select Subject</label>
                                    <select class="form-control" id="subject_id" name="subject_id">
                                        <option value="{{old('subject_id')}}" disabled selected>--Select Subject--</option>
                                        @foreach($emails as $subject)
                                        <option {{ $subject->id == $subject_id ? "selected" : ""  }} value="{{route('import-export', [$month,$year, $subject->id] ) }}" >{{$subject->subject}}</option>
                                        @endforeach 
                                    </select>

                                    @error('subject_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">{{ __(' Import/Export Employee List') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">                       
                                    <thead  class="text-primary"> 
                                        <tr>
                                            <th class="disable-sorting"> 
                                                <input type="checkbox"  id="select_all_checkbox"  >
                                            </th>
                                            <th>Employee Name</th>
                                            <th>Basic Salary</th>
                                            <th>Total Leave</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $employee)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="checkbox[]" class="employee_checkbox" id="{{ $employee->id }}" value="{{ $employee->id }}" >
                                            </td> 
                                            <td>{{ $employee->name}}</td> 
                                            <td>{{ $employee->basic_salary }}</td> 
                                                <td>{{!empty($leaves[$employee->id])? $leaves[$employee->id] : 0}}</td> 
                                            <td class="td-actions  text-right row ml-auto">
                                                <form  method="post" action="{{route('generate-salary.store')}}"> 
                                                    @csrf
                                                    <input type="hidden" class="form-group" id="employee_id" name="employee_id" value="{{ $employee->id }}">
                                                    <input type="hidden" class="form-group" id="month" name="month" value="{{$month}}">
                                                    <input type="hidden" class="form-group" id="year" name="year" value="{{$year}}">
                                                    <input type="hidden" class="form-group" id="download_pdf" name="download_pdf" value="1">
                                                    <button type="submit" class="btn btn-success">Download Pdf</button>
                                                </form>
                                                <form  method="post" action="{{route('generate-salary.store')}}"> 
                                                    @csrf
                                                    <input type="hidden" class="form-group" id="employee_id" name="employee_id" value="{{ $employee->id }}">
                                                    <input type="hidden" class="form-group" id="month" name="month" value="{{$month}}">
                                                    <input type="hidden" class="form-group" id="year" name="year" value="{{$year}}">
                                                    <input type="hidden" class="form-group" id="subject_id" name="subject_id" value="{{$subject_id}}">
                                                    <input type="hidden" class="form-group" id="email" name="email" value="1">
                                                    <button type="submit" class=" btn btn-info" >Send to Email </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    <button type="button" class="btn btn-info" id="send-to-selected-users">Send email to selected employee </button>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

<script type="text/javascript">
   jQuery(document).on('click', '#select_all_checkbox', function(){
        if ($(this).prop('checked')==true){ 
            jQuery('.employee_checkbox').prop('checked', true);
        }else{
            jQuery('.employee_checkbox').prop('checked', false);
        }
   });
   jQuery(document).on('click', '#send-to-selected-users', function(){
       if( !jQuery("#subject_id").val() ){
           alert("Please select mail subject");
           return false;
       }
       jQuery(this).html('Sending Email...');
       var ids = [];
       var month = {{$month}};
       var year = {{$year}};
       var subject_id = {{$subject_id}};
        jQuery('.employee_checkbox:checked').each(function(){
            ids.push(jQuery(this).val());
        });
        if( ids.length ){
            jQuery.ajax({
               type:'POST',
               url:'{{route("send-selected-email")}}',
               data:{_token : '{{csrf_token()}}',
                    employee_id : ids,
                    month : month,
                    year : year,
                    subject_id : subject_id
                },
               success:function(data) {
                jQuery("#send-to-selected-users").html('Send email to selected employee ');
                alert( data );
               }
            });
        }else{
            alert('Please select employees');
            jQuery("#send-to-selected-users").html('Send email to selected employee ');
        }
   });
</script>
@endpush

