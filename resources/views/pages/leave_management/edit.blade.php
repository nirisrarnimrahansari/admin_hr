@extends('layouts.app', ['activePage' => 'leave_management-leave_detail', 'titlePage' => __('')])

@section('content')
<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" enctype="multipart/form-datay" action="{{route('leave-management.update', [$leave_management->id])}}"> 
                    @csrf
                    @method('PATCH')
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Update Employee Leave') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="employee_id" class="col-form-label">Employee Name</label>
                                        <select class="form-control" id="employee_id" name="employee_id">
                                            <option value="{{$leave_management->employee_id}}"  disabled selected>--select employee name--</option>
                                            @foreach($employees as $value)
                                            <option value="{{ $value->id}}" {{ $value->id == $leave_management->employee_id ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @endforeach 
                                        </select>
                                            @error('employee_id')
                                                    <span class="text-danger">{{$message}}</span>
                                            @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="leave_type" class="col-form-label">Leave Type</label>
                                            <select class="form-control"  id="leave_type" name="leave_type">
                                                @foreach($leave_status as $value)
                                                    <option value="{{ $value->id}}" {{ $value->id == $leave_management->leave_type ? "selected" : ""  }} >{{ $value->name }}</option>
                                                @endforeach  
                                            </select>
                                            @error('leave_type')
                                                    <span class="text-danger">{{$message}}</span>
                                            @enderror
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="leave_date" class=" col-form-label">Start Date</label>
                                    <input type="date" value="{{$leave_management->leave_date}}" class="form-control" name="leave_date" id="leave_date"  placeholder="" >
                                    @error('leave_date')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-group col-lg-6 mt-5">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a class="btn btn-md fs-1 btn-light" href="/leave-management">Cancel</a>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
     </div>
</div>
@endsection
