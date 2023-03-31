@extends('layouts.app', ['activePage' => 'leave_management-leave_detail', 'titlePage' => __('')])

@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_leave_management', $user_permisions ) )
<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" enctype="multipart/form-datay" action="{{route('leave-management.store')}}"> 
                        @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Employee Leave Management Form') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 mt-2">
                                    <label for="employee_id">Employee Name</label>
                                    <select class="form-control"  value="{{old('employee_id')}}" id="employee_id" name="employee_id">
                                        <option value="" disabled selected>--Select Employee Name--</option>
                                        @foreach($employees as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach 
                                    </select>
                                        @error('employee_id')
                                                <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="leave_type">Leave Type</label>
                                        <select class="form-control" value="{{old('leave_type')}}" id="leave_type" name="leave_type">
                                        <option  disabled selected>--Select Employee Leave Type--</option>
                                            @foreach($leave_status as $value)
                                                <option value="{{ $value->id}}" >{{ $value->name }}</option>
                                            @endforeach 
                                        </select>
                                        @error('leave_type')
                                                <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="row">
                                    <div class="col-md-3 mt-2">
                                        <label for="leave_date" class=" col-form-label">Start Date</label>
                                        <input type="text" value="{{old('leave_date')}}" class="form-control" name="leave_date" id="leave_date"  placeholder="" >
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label>Select Month</label>
                                            <select class="form-control" name="leave_month">
                                                @for($i = 1; $i <= 12; $i++)
                                                    <option {{ date('m', strtotime( "-1 month", time() ) ) == $i ? "selected" : ""}} value="{{$i}}">{{ date('F', mktime(0, 0, 0, $i, 1)); }} ( {{$i}} )</option>
                                                @endfor
                                            </select>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label for="select_year"> Select Year</label>
                                            <select class="form-control" name="leave_year">
                                                @for($i = date('Y', time() ); $i >= 2004; $i--)
                                                    <option>{{$i}}</option>
                                                @endfor
                                            </select>
                                    </div>
                                        @error('leave_date')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <button type="submit" class="btn  btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">{{ __('Employee Leave Management List') }}</h4>
                    </div>
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">  
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mt-2">
                                    <label>Select Month</label>
                                    <select class="form-control" name="month">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option {{ date('m', strtotime( "-1 month", time() ) ) == $i ? "selected" : ""}} value="{{$i}}">{{ date('F', mktime(0, 0, 0, $i, 1)); }} ( {{$i}} )</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <label for="select_year"> Select Year</label>
                                    <select class="form-control" name="year">
                                        @for($i = date('Y', time() ); $i >= 2004; $i--)
                                            <option>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <label>Select CSV file</label>
                                    <input type="file" name="file" class="form-control">  
                                </div>
                                <div class="col-md-3 mt-3">
                                    <button class="btn btn-success">Import Leave</button>  
                                </div>
                            </div>
                        </div>
                    </form>   
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead  class="text-primary">
                                        <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Leave Type</th>
                                        <th>Leave Date</th>
                                        @if(in_array('update_leave_management', $user_permisions ) || in_array('delete_leave_management', $user_permisions ) )
                                        <th>Action</th>
                                        @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($leave_management)
                                        @php $i=0; @endphp
                                        @foreach($leave_management as $value)
                                        @php $i++; @endphp
                                            <tr>
                                                <td>@php echo $i; @endphp</td>
                                                <td>@if(!empty($value->employee_id))
                                                        {{ $value->employee_info['name'] }}
                                                    @endif
                                                </td>
                                                <td>@if(!empty($value->leave_type))
                                                        {{ $value->leave_info['name'] }}
                                                    @endif
                                                </td>
                                                <td>{{ date('d M Y', strtotime($value->leave_date)) }}</td> 

                                                <td class="td-actions  text-right row ml-auto">
                                                @if( in_array('update_leave_management', $user_permisions ) )
                                                <a href="{{route('leave-management.edit',[$value->id])}}" rel="tooltip" class="btn btn-success"><i class="material-icons">edit</i></a>
                                                @endif
                                                @if( in_array('delete_leave_management', $user_permisions ) )
                                                    <form  method="post" action="{{route('leave-management.destroy',[$value->id])}}"> 
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" rel="tooltip" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="material-icons">close</i></button>
                                                    </form>
                                                @endif
                                                </td>       
                                            </tr>
                                        @endforeach
                                    @endif

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

@push('js')
 
  @if (session('status'))
      <div class="alert alert-success">
          <p class="msg"> {{ session('status') }}</p>
      </div>
  @endif


@endpush