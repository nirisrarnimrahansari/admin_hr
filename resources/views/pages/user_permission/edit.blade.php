@extends('layouts.app', ['activePage' => 'list', 'titlePage' => __('')])
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('user-permission.update', [$user_permission->id])}}"> 

                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Update User Permission Slug') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class=" col-lg-6">
                                        <label for="name"  class="col-form-label">  Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{$user_permission->name}}" >
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>  
                                <div class=" col-lg-6">
                                        <label for="slug"  class="col-form-label"> Slug</label>
                                        <input type="text" class="form-control" id="slug" name="slug" value="{{$user_permission->slug}}" >
                                        @error('slug')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mt-5">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a class="btn btn-md fs-1 btn-light" href="/user-permission" >Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
