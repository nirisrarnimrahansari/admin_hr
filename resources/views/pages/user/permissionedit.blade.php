@extends('layouts.app', ['activePage' => 'user', 'titlePage' => __('')])
@section('content')
<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('permission.update', [$permission->id])}}"> 
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Update Permission Page') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="employee_id">Employee Name</label>
                                    <select class="form-control" value="{{old('employee_id')}}" id="employee_id" name="employee_id">
                                        <option value="{{ $permission->employee_id }}" disabled selected>--Select Employee Name--</option>
                                        @foreach($employees as $value)
                                    <option value="{{ $value->id}}" {{ $value->id == $permission->employee_id ? 'selected' : '' }}>{{ $value->name }}</option>
                                        @endforeach 
                                    </select>
                                    @error('employee_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class=" col-lg-6">
                                        <label for="manager_id"> User Name</label>
                                        <select class="form-control" value="{{old('manager_id')}}" id="manager_id" name="manager_id">
                                        <option value="{{$permission->manager_id }}" disabled selected>--Select User Name--</option>
                                        @foreach($user as $value)
                                    <option value="{{ $value->id}}" {{ $value->id == $permission->manager_id ? 'selected' : '' }}>{{ $value->name }}</option>
                                        @endforeach 
                                    </select>
                                    @error('manager_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <button type="submit" class="btn btn-primary">update</button>
                                <a class="btn btn-md fs-1 btn-light" href="/permission" >Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
