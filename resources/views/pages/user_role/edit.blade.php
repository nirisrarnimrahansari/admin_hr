@extends('layouts.app', ['activePage' => 'user-role', 'titlePage' => __('')])
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('user-role.update', [$user_role->id])}}"> 
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Update User Role') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="user_name"  class="col-form-label"> Update User Role Name</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" value="{{$user_role->user_name}}">
                                    @error('user_name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                @error('user_permission')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <div class="row">
                                    @foreach($user_permission as $permission)
                                        @php 
                                            $checked = "";
                                            $user_permissions = json_decode($user_role->user_permission);
                                            if( in_array($permission->id, $user_permissions) ){
                                                $checked = "checked";
                                            }
                                        @endphp
                                        <div class="col-sm-4">
                                            <input type="checkbox" {{$checked}} name="user_permission[]" value="{{$permission->id}}" id="{{$permission->slug}}"> <label for="{{$permission->slug}}">{{$permission->name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mt-5">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a class="btn btn-md fs-1 btn-light" href="/user-role" >Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

