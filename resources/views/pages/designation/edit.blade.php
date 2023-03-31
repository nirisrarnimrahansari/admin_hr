@extends('layouts.app', ['activePage' => 'designation', 'titlePage' => __('')])
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('designation.update', [$designation->id])}}"> 
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Update Designation') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class=" col-lg-6">
                                        <label for="name"  class="col-form-label"> Designation Name</label>
                                        <input type="name" value="{{$designation->name}}"  class="form-control" id="name" name="name">
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror 
                                </div>
                                <div class="form-group col-lg-6 mt-5">
                                        <button type="submit" class="btn btn-primary">Update</button> 
                                        <a class="btn btn-md fs-1 btn-light" href="/designation" >Cancel</a>

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
