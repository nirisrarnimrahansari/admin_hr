@extends('layouts.app', ['activePage' => 'user-list', 'titlePage' => __('')])
@section('content')

@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
    @endphp
@if( in_array('create_user_permission', $user_permisions ) )

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('user-permission.store')}}"> 
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Add User Permission Slug') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                        <label for="name"  class="col-form-label"> Designation Edit Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder=" Designation Edit">
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>  
                                <div class="col-lg-6">
                                        <label for="slug"  class="col-form-label"> Designation-Edit Operation</label>
                                        <input type="text" class="form-control" id="slug" name="slug" placeholder="CRUD Operation">
                                        @error('slug')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6 mt-5">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                </div>
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
                    <h4 class="card-title">{{ __('User Permission Slug List') }}</h4>
                </div>
                <div class="card-body">
                    <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead  class="text-primary">
                                <tr>
                                <th>Id</th>
                                <th> Name</th>
                                <th> Slug</th>
                                @if(in_array('update_user_permission', $user_permisions ) || in_array('delete_user_permission', $user_permisions ) )
                                <th>Action</th>
                                @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=0; @endphp
                                @foreach($user_permission as $value)
                                @php $i++; @endphp
                                    <tr>
                                        <td>@php echo $i; @endphp</td>
                                        <td>{{ $value->name }}</td> 
                                        <td>{{ $value->slug }}</td> 
                                        <td class="td-actions text-right row ml-auto">
                                        @if( in_array('update_user_permission', $user_permisions ) )
                                            <a href="{{route('user-permission.edit',[$value->id])}}" rel="tooltip" class="btn btn-success"><i class="material-icons">edit</i></a>
                                        @endif
                                        @if( in_array('delete_user_permission', $user_permisions ) )
                                            <form  method="post" action="{{route('user-permission.destroy',[$value->id])}}"> 
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

@endsection

