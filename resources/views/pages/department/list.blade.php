@extends('layouts.app', ['activePage' => 'department', 'titlePage' => __('')])

@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_department', $user_permisions ) )
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <form  method="post" action="{{route('department.store')}}"> 
                @csrf
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">{{ __('Add Department') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="department_name"  class="col-form-label"> Department Name</label>
                                <input type="text" class="form-control" id="department_name" name="department_name" placeholder="Enter Department Name">
                                @error('department_name')
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
                        <h4 class="card-title">{{ __(' Department List') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead  class="text-primary">
                                        <tr>
                                        <th>Id</th>
                                        <th>Department Name</th>
                                        @if(in_array('update_department', $user_permisions ) || in_array('delete_department', $user_permisions ) )
                                            <th>Action</th>
                                        @endif    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 0  @endphp
                                        @foreach($department as $value)
                                            @php $i++; @endphp
                                            <tr>
                                            <td> @php echo $i; @endphp</td>
                                                <td>{{ $value->department_name }}</td> 
                                                <td class="td-actions text-right row ml-auto">
                                                @if( in_array('update_department', $user_permisions ) )
                                                    <a href="{{route('department.edit',[$value->id])}}" rel="tooltip" type="button" class="btn btn-success"><i class="material-icons">edit</i></a>
                                                @endif
                                                @if( in_array('delete_department', $user_permisions ) )
                                                <form  method="post" action="{{route('department.destroy',[$value->id])}}"> 
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
