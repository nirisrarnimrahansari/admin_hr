@extends('layouts.app', ['activePage' => 'leave_management-calender', 'titlePage' => __('')])
@section('content')
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
            <div class="card">
               <div class="card-header card-header-primary">
                     <h4 class="card-title">{{ __('Leave Management Calender') }}</h4>
                     <p class="card-description">Employee Calender Leave</p>
               </div>
               <div class="card-body row"> 
                  <div class="col-md-6">
                     <select class="form-control"  value="{{old('employee_name')}}" id="employee_name" name="employee_name">
                        <option value="" disabled selected>--Select Employee Name--</option>
                        @foreach($employees as $value)
                           <option value="{{route('calender', [$month,$year, $value->id])}}" {{ $value->id == $employee_id ? "selected" : ""  }}>{{$value->name}}</option>
                        @endforeach 
                     </select>
                  </div>

                  <div class="offset-lg-6 col-6 ">
                     <div class="form-group row"> 
                        <ul class="list-group">
                           <li class="list-group-item py-0 "><span><i class="material-icons text-danger rounded-circle bg-danger" style="font-size: 13px;">lens</i>  </span>Sunday</li>
                           <li class="list-group-item py-0 "><span><i class="material-icons text-success rounded-circle bg-success" style="font-size: 13px;">lens</i>  </span>Working Day</li>
                           <li class="list-group-item py-0 "><span><i class="material-icons text-warning rounded-circle bg-warning" style="font-size: 13px;">lens</i> </span>Holidays</li>
                           @foreach($leave_status as $value)
                                 <li class="list-group-item py-0"><span><i style="color:{{$value->color}}; background-color:{{$value->color}}; font-size: 13px;" class="material-icons rounded-circle">lens</i> </span>{{$value->name}}</li>
                           @endforeach
                        </ul> 
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
               <div class="card-header text-center card-header-primary">
                     <h4 class="card-title">{{$strMonth}} {{$year}}</h4>
               </div>
               <table class="table mt-5">
                  <thead>
                     <tr>
                        <th abbr="Sunday" scope="col" class="bg-danger " title="Sunday" style="font-weight: bold;">S</th>
                        <th abbr="Monday" scope="col" title="Monday" style="font-weight: bold;">M</th>
                        <th abbr="Tuesday" scope="col" title="Tuesday" style="font-weight: bold;">T</th>
                        <th abbr="Wednesday" scope="col" title="Wednesday" style="font-weight: bold;">W</th>
                        <th abbr="Thursday" scope="col" title="Thursday" style="font-weight: bold;">T</th>
                        <th abbr="Friday" scope="col" title="Friday" style="font-weight: bold;">F</th>
                        <th abbr="Saturday" scope="col" title="Saturday" style="font-weight: bold;">S</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
               
                     @if(0 != $dayOfWeek) 
                     <td colspan="{{$dayOfWeek}}"> </td>
                     @endif
                     @for($i=1;$i<=$daysInMonth;$i++)
                        @if($i == $numDay && date('m', $time) == $month)
                           <td id="today" class="current date-picker">
                        @else 
                           <td class='date-picker'>
                        @endif 
                        @php $text_color = ""; 
                        $badge_color = "";
                        @endphp
                        @if ( !empty($holidays) ) 
                           @foreach( $holidays as $holiday) 
                              @if( intval( $i ) === intval( date( 'd', strtotime( $holiday->holiday_date ) ) ) )
                                 @php $text_color = "text-warning"; @endphp
                                 <span class="badge badge-warning">{{$holiday->holiday_name}} </span> 
                              @endif
                           @endforeach                                      
                        @endif
                        @if(!empty($leaves) )
                              @foreach( $leaves as $leave)
                                 @if( intval( $i ) === intval( date( 'd', strtotime( $leave->leave_date ) ) ) )
                                 
                                    <form action="{{route('leave-management.updateType', $leave->id)}}" method="POST" id="leave-status-form-{{$i}}"> 
                                       @csrf
                                       @method('POST')
                                       @foreach($leave_status as $value)
                                          @php 
                                          if( $value->id == $leave->leave_type  ){
                                             $badge_color = "background:".$value->color;
                                             break;
                                          } 
                                          @endphp
                                       @endforeach 
                                       <span class="badge" style="{{$badge_color}}">
                                       <select class="form-control" onChange="change_leave_status('#leave-status-form-{{$i}}')" id="leave_type" name="leave_type">
                                           <option value="0">Working Day</option>
                                          @foreach($leave_status as $value)
                                             <option value="{{ $value->id}}" {{ $value->id == $leave->leave_type ? "selected" : ""  }} >{{ $value->name }}</option>
                                          @endforeach  
                                       </select>
                                    </span> 
                                    </form>
                                 @endif 
                              @endforeach
                           @endif 
                           <br/><span class="{{$text_color}}">{{$i}}</span>
                        </td>
                        @if(date('w', mktime(0,0,0,$month, $i, $year)) == 6)
                           </tr><tr>
                        @endif
                     @endfor
                     </tr>
                  </tbody>
               </table>
               <div class="btn-group">
                  <a href="{{ route('calender', [$pre_month,$pre_year,$employee_id]) }}" class="btn btn-primary"><< Prev</a>
                  <a href="{{ route('calender', [$next_month,$next_year,$employee_id]) }}" class="btn btn-secondary">Next >></a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection