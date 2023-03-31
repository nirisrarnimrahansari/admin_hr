@extends('layouts.app', ['activePage' => 'user-role', 'titlePage' => __('')])
@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_user_role', $user_permisions ) )

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('user-role.store')}}"> 
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('User Role') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class=" col-lg-6">
                                    <label for="user_name"  class="col-form-label"> User Role Name</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User Role Name">
                                    @error('user_name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                @foreach($user_permission as $value)
                                    <div class="col-sm-4">
                                        <input type="checkbox" name="user_permission[]" value="{{$value->id}}" id="{{$value->slug}}"> <label for="{{$value->slug}}">{{$value->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group col-lg-6 mt-5">
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
                    <h4 class="card-title">{{ __('User Role List') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead  class="text-primary">
                                    <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    @if(in_array('update_user_role', $user_permisions ) || in_array('delete_user_role', $user_permisions ) )
                                    <th>Action</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach($user_role as $value)
                                    @php $i++; @endphp
                                        <tr>
                                            <td>@php echo $i; @endphp</td>
                                            <td>{{ $value->user_name }}</td> 
                                            <td>@if(!empty(($value->user_permission)))
                                                    @php 
                                                        $permissions = json_decode($value->user_permission);
                                                        $all_permission = \App\Models\UserPermission::whereIn('id',$permissions)->where('deleted_date', NULL)->get();
                                                    @endphp
                                                    @foreach( $all_permission as $permission)
                                                        {{ $permission->name }}, 
                                                    @endforeach
                                                @endif
                                            
                                            </td>
                                            <td class="td-actions text-right row ml-auto">
                                            @if( in_array('update_user_role', $user_permisions ) )
                                                <a href="{{route('user-role.edit',[$value->id])}}" rel="tooltip" class="btn btn-success"><i class="material-icons">edit</i></a>
                                            @endif
                                            @if( in_array('delete_user_role', $user_permisions ) )
                                                <form  method="post" action="{{route('user-role.destroy',[$value->id])}}"> 
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
