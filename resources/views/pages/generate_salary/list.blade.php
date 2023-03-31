@extends('layouts.app', ['activePage' => 'generate-salary', 'titlePage' => __('')])
@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_generate_salary', $user_permisions ) )
<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('generate-salary.store')}}"> 
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Generate Salary Of Employee') }}</h4>
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="employee_id"> Employee Name</label>
                                    <select class="form-control" id="employee_id" value="{{old('employee_id')}}" name="employee_id">
                                        <option value="" disabled selected>--Select Employee Name--</option>
                                        @foreach($employees as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach 
                                    </select>
                                    @error('employee_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-3">
                                    <label for="select_month"> Select Month</label>
                                    <select class="form-control" name="month">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option {{ date('m', strtotime( "-1 month", time() ) ) == $i ? "selected" : ""}} value="{{$i}}">{{ date('F', mktime(0, 0, 0, $i, 1)); }} ( {{$i}} )</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="select_year"> Select Year</label>
                                    <select class="form-control" name="year">
                                        @for($i = date('Y', time() ); $i >= 2004; $i--)
                                            <option>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="subject_id"> Select Subject</label>
                                    <select class="form-control" name="subject_id">
                                        <option value="" disabled selected>--Select Subject--</option>
                                        @foreach($emails as $value)
                                        <option value="{{$value->id}}">{{$value->subject}}</option>
                                        @endforeach 
                                    </select>

                                    @error('subject_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                                <div class="row mt-3">
                                    <div class="col-lg-3">
                                        <label for="adjust_leave">Adjust Leave</label>
                                        <input type="number" class="form-control" min="0" max="31" id="adjust_leave" name="adjust_leave" placeholder="Enter adjustable leave ">
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12" class="checkbox" >
                                        <label><input type="checkbox" class="form-group" value="1" name="email" /> Send Email to Employee</label>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <label><input type="checkbox" class="form-group" value="1" name="download_pdf" checked/> Download PDF</label>
                                    </div>
                                </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Generate Salary</button>
                            </div>
                           </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

        