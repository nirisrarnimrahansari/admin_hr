@extends('layouts.app', ['activePage' => 'employee-list', 'titlePage' => __('')])
@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __(' Employee Registration List') }}</h4>
                    <p class="card-description">
                        Employee list
                    </p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                
                                <thead  class="text-primary">
                                    <tr>
                                    <th>Id</th>
                                    <th> Name</th>
                                    <th>Father Name</th>
                                    <th>Email ID</th>
                                    <th>Date of Birth</th>
                                    @if(in_array('update_employee', $user_permisions ) || in_array('delete_employee', $user_permisions ) || in_array('view_employee', $user_permisions ) )
                                    <th>Action</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach($employees as $value)
                                    @php $i++; @endphp  
                                    <tr>
                                            <td>@php echo $i; @endphp</td>
                                            <td>{{ $value->name }}</td> 
                                            <td>{{ $value->father_name }}</td> 
                                            <td>{{ $value->email_id }}</td> 
                                            <td>{{ date('d M Y', strtotime($value->dob)) }}</td> 
                                            <td class="td-actions text-right row ml-auto">
                                            <td class="td-actions text-right row ml-auto">
                                                <form  method="post" action="{{route('employee-email')}}"> 
                                                    @csrf
                                                    @foreach($OfferLetter as $subject)
                                                        <input type="hidden" class="form-group" id="id" name="id" value="{{$subject->id}}">
                                                    @endforeach
                                                    <input type="hidden" class="form-group" id="employee_id" name="employee_id" value="{{ $value->id }}">
                                                    <input type="hidden" class="form-group" id="name" name="name" value="{{ $value->name }}">
                                                    <input type="hidden" class="form-group" id="designation" name="designation" value="{{$value->designation_id}}">
                                                    <input type="hidden" class="form-group" id="joining_date" name="joining_date" value="{{$value->joining_date}}">
                                                    <input type="hidden" class="form-group" id="basic_salary" name="basic_salary" value="{{$value->basic_salary}}">
                                                    <input type="hidden" class="form-group" id="login_time" name="login_time" value="{{$value->shift_id }}">
                                                    <input type="hidden" class="form-group" id="logout_time" name="logout_time" value="{{$value->shift_id }}">
                                                    <input type="hidden" class="form-group" id="download_pdf" name="download_pdf" value="1">
                                                    <button type="submit" class="btn btn-success"><i class="material-icons">download</i></button>
                                                </form>
                                                <form  method="post" action="{{route('employee-email')}}"> 
                                                    @csrf
                                                    @foreach($OfferLetter as $subject)
                                                        <input type="hidden" class="form-group" id="id" name="id" value="{{$subject->id}}">
                                                    @endforeach
                                                    <input type="hidden" class="form-group" id="employee_id" name="employee_id" value="{{ $value->id }}">
                                                    <input type="hidden" class="form-group" id="name" name="name" value="{{ $value->name }}">
                                                    <input type="hidden" class="form-group" id="designation" name="designation" value="{{$value->designation_id}}">
                                                    <input type="hidden" class="form-group" id="joining_date" name="joining_date" value="{{$value->joining_date}}">
                                                    <input type="hidden" class="form-group" id="basic_salary" name="basic_salary" value="{{$value->basic_salary}}">
                                                    <input type="hidden" class="form-group" id="login_time" name="login_time" value="{{$value->shift_id }}">
                                                    <input type="hidden" class="form-group" id="logout_time" name="logout_time" value="{{$value->shift_id }}">
                                                    <input type="hidden" class="form-group" id="email" name="email" value="1"> 
                                                    <button type="submit" class="btn btn-info" ><i class="material-icons">mail</i> </button>
                                                </form>
                                            @if( in_array('update_employee', $user_permisions ) )
                                                <a href="{{route('employee.edit',[$value->id])}}" rel="tooltip" class="btn btn-success"><i class="material-icons">edit</i></a>
                                            @endif
                                            @if( in_array('delete_employee', $user_permisions ) )
                                                <form  method="post" action="{{route('employee.destroy',[$value->id])}}"> 
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" rel="tooltip" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="material-icons">close</i></button>
                                                </form>
                                            @endif
                                            @if( in_array('view_employee', $user_permisions ) )
                                                <a href="{{route('employee.show', [$value->id])}}" rel="tooltip" class="btn btn-success"><i class="material-icons">visibility</i></a>
                                            @endif
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
