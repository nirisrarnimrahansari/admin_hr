@extends('layouts.app', ['activePage' => 'holiday', 'titlePage' => __('')])

@section('content') 
<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('holiday.update', [$holiday->id])}}"> 
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Update Holiday') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class=" col-lg-6">
                                        <label for="holiday_name"  class="col-form-label"> Holiday Name</label>
                                        <input type="text" value="{{$holiday->holiday_name}}" class="form-control" id="holiday_name" name="holiday_name">
                                        @error('holiday_name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class=" col-lg-6">
                                        <label for="holiday_date"  class="col-form-label"> Holiday Date</label>
                                        <input type="date" value="{{$holiday->holiday_date}}" class="form-control" id="holiday_date" name="holiday_date" >
                                        @error('holiday_date')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6 mt-5">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a class="btn btn-md fs-1 btn-light" href="/holiday" >Cancel</a>
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