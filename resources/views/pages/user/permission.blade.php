@extends('layouts.app', ['activePage' => 'user', 'titlePage' => __('')])
@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_manager_access', $user_permisions ) )
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('permission.store')}}"> 
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Permission Page') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="employee_id"> Employee Name</label>
                                    <select class="form-control" value="{{old('employee_id')}}" id="employee_id" name="employee_id">
                                        <option value="" disabled selected>--Select Employee Name--</option>
                                        @foreach($employees as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach 
                                    </select>
                                    @error('employee_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class=" col-lg-6">
                                        <label for="manager_id"> User Name</label>
                                        <select class="form-control" value="{{old('manager_id')}}" id="manager_id" name="manager_id">
                                        <option value="" disabled selected>--Select User Name--</option>
                                        @foreach($user as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach 
                                    </select>
                                    @error('manager_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <button type="submit" class="btn btn-primary">Add</button>
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
                    <h4 class="card-title">{{ __('Permission Access List') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    
                                <thead  class="text-primary">
                                    <tr>
                                    <th>Id</th>
                                    <th>Employee Name</th>
                                    <th>Manager Name</th>
                                    @if(in_array('update_manager_access', $user_permisions ) || in_array('delete_manager_access', $user_permisions ) )
                                    <th>Action</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @if($permission)
                                    @php $i=0; @endphp
                                    @foreach($permission as $value)
                                        @php $i++; @endphp
                                        <tr>
                                            <td>@php echo $i; @endphp</td>
                                            <td>{{ $value->employee_info['name'] }}</td>
                                            <td>{{ $value->manager_info['name'] }}</td> 
                                            <td class="td-actions  text-right row ml-auto">
                                            @if( in_array('update_manager_access', $user_permisions ) )
                                                <a href="{{route('permission.edit',[$value->id])}}" rel="tooltip" class="btn btn-success"><i class="material-icons">edit</i></a>
                                            @endif
                                            @if( in_array('delete_manager_access', $user_permisions ) )
                                                <form  method="post" action="{{route('permission.destroy',[$value->id])}}"> 
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
