@extends('layouts.app', ['activePage' => 'shift', 'titlePage' => __('')])

@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_shift', $user_permisions ) )

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('shift.store')}}"> 
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Add Shifting Time') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 mt-3">
                                    <label for="name" class="col-form-label">Name</label>
                                    <input type="text" value="{{old('name')}}" class="form-control" name="name" id="name" placeholder="Enter Shift Name"  >
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mt-3">
                                    <label for="login_time" class=" col-form-label">Login</label>
                                    <input type="time" value="{{old('login_time')}}" class="form-control" name="login_time" id="login_time"  placeholder="shifting Time" >
                                    @error('login_time')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mt-3">
                                    <label for="logout_time" class="col-form-label">Logout</label>
                                    <input type="time" class="form-control" value="{{old('logout_time')}}" name="logout_time" id="logout_time" placeholder="Logout Time" >
                                    @error('logout_time')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mt-3">
                                    <label for="buffer_time" class="col-form-label">Buffer Time</label>
                                    <input type="number" value="{{old('buffer_time')}}" class="form-control" name="buffer_time" id="buffer_time" placeholder="Buffer Time" >
                                    @error('buffer_time')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mt-5">
                                <button type="submit" class="btn btn-primary mt-3">Add</button>
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
                    <h4 class="card-title">{{ __(' Shifting Time List') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead  class="text-primary">
                                    <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Login Time</th>
                                    <th>Logout Time</th>
                                    <th>Buffer Time</th>
                                    @if(in_array('update_shift', $user_permisions ) || in_array('delete_shift', $user_permisions ) )
                                    <th>Action</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach($shift as $value)
                                    @php $i++; @endphp
                                        <tr>
                                            <td>@php echo $i; @endphp</td>
                                            <td>{{ $value->name }}</td> 
                                            <td>{{ $value->login_time }}</td> 
                                            <td>{{ $value->logout_time }}</td> 
                                            <td>{{ $value->buffer_time }}</td> 
                                            <td class="td-actions  text-right row ml-auto">
                                            @if( in_array('update_shift', $user_permisions ) )      
                                                <a href="{{route('shift.edit',[$value->id])}}" rel="tooltip" class="btn btn-success"><i class="material-icons">edit</i></a>
                                            @endif
                                            @if( in_array('delete_shift', $user_permisions ) )      
                                                <form  method="post" action="{{route('shift.destroy',[$value->id])}}"> 
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" rel="tooltip" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="material-icons">close</i></button>
                                                </form>
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

