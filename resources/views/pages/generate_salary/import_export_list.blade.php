@extends('layouts.app', ['activePage' => 'generate_salary-import_export', 'titlePage' => __('')])

@section('content') 
<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" > 
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __("Generate Salary Of Employee's") }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="select_month"> Select Month</label>
                                    <select class="form-control" value="{{old('month')}}" id="month" name="month">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option {{ date('m', strtotime( "-1 month", time() ) ) == $i ? "selected" : ""}} value="{{$i}}">{{ date('F', mktime(0, 0, 0, $i, 1)); }} ( {{$i}} )</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="select_year"> Select Year</label>
                                    <select class="form-control" name="year">
                                        @for($i = date('Y', time() ); $i >= 2004; $i--)
                                            <option>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-3">
                                    <button type="submit" href="{{ route('import-export.show', [$month, $year]) }}" class="btn btn-primary">Show employee List</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">{{ __(' Employee List') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                
                                    <thead  class="text-primary">
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Basic Salary</th>
                                            <th>Total Deduction</th>
                                            <th>Final Salary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=0; @endphp
                                    @foreach($employees as $value)
                                    @php $i++; @endphp  
                                    <tr>
                                            <td>{{ $value->name}}</td> 
                                            <td>{{ $value->basic_salary }}</td> 
                                            <td>0</td> 
                                            <td>0</td> 
                                            <td class="td-actions  text-right row ml-auto">
                                            <form  method="post" action="{{route('import-export.store')}}"> 
                                                    <div>
                                                        <input type="hidden" class="form-group" id="employee_id" name="employee_id">
                                                    </div>
                                                    <div>
                                                        <input type="hidden" class="form-group" id="month" name="month">
                                                    </div>
                                                    <div>
                                                        <input type="hidden" class="form-group" id="year" name="year">
                                                    </div>
                                                    <!-- <div>
                                                        <input type="hidden" class="form-group" id="email" name="email">
                                                    </div> -->
                                                    <button type="button" class=" btn btn-info mr-1" name="email">Send to Email </button>
                                                    <button type="submit" class="btn btn-success" name="download_pdf" >Download Pdf</button>
                                            </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- @extends('layouts.app', ['activePage' => 'generate_salary-import_export', 'titlePage' => __('')])
@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_import_export', $user_permisions ) )
@php
   $time    = time();
   $numDay  = date('d', $time);
   $strMonth = date('F', mktime(0, 0, 0, $month, 10));
   $firstDay = mktime(0,0,0,$month,1,$year);
   $daysInMonth = cal_days_in_month(0, $month, $year);
   $dayOfWeek = date('w', $firstDay);
   $pre_month = 1 < $month ? intval($month)-1 : 12;
   $pre_year = 1 < $month ? $year : intval( $year ) - 1;
   $next_month = 12 > $month ? intval($month)+1 : 1 ;
   $next_year = 12 > $month ? $year :  intval( $year ) + 1;
@endphp
<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post"> 
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Generate Salary Of Employee') }}</h4>
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                
                                <div class="col-lg-3">
                                    <label for="select_month"> Select Month</label>
                                    <select class="form-control" name="month"   value="{{old('month')}}" id="month">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option {{ date('m', strtotime( "month", time() ) ) == $i ? "selected" : ""}} value="{{$i}}">{{ date('F', mktime(0, 0, 0, $i, 1)); }} ( {{$i}} )</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="select_year"> Select Year</label>
                                    <select class="form-control" name="year"  value="{{old('year')}}" id="year">
                                        @for($i = date('Y', time() ); $i >= 2003; $i--)
                                            <option>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                    <button href="{{route('import-export', [$month, $year])}}"  type="submit" class="btn btn-primary">Show List Salary</button>
                                    <div class="btn-group">
                  <a href="{{ route('import-export', [$pre_month,$pre_year]) }}" class="btn btn-primary"><< Prev</a>
                  <a href="{{ route('import-export', [$next_month,$next_year]) }}" class="btn btn-secondary">Next >></a>
               </div>
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

         -->