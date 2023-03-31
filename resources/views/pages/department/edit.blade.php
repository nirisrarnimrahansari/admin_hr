@extends('layouts.app', ['activePage' => 'department', 'titlePage' => __('')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('department.update', [$department->id])}}"> 
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Update Department') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class=" col-lg-6">
                                        <label for="department_name"  class="col-form-label"> Department Name</label>
                                        <input type="text" value="{{$department->department_name}}"  class="form-control" id="department_name" name="department_name" >
                                        @error('department_name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6 mt-5">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a class="btn btn-md fs-1 btn-light" href="/department" >Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

