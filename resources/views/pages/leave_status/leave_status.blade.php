@extends('layouts.app', ['activePage' => 'leave-status', 'titlePage' => __('')])

@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_leave_status', $user_permisions ) )

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('leave-status.store')}}"> 
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Add Leave Status') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class=" col-lg-6">
                                        <label for="name"  class="col-form-label">  Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class=" col-lg-6">
                                        <label for="value"  class="col-form-label">  Value</label>
                                        <input type="text" class="form-control" id="value" name="value" placeholder="Enter Value">
                                        @error('value')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class=" col-lg-6">
                                        <label for="color" class="col-form-label">Color Code</label>
                                        <input type="text" id="cp2" class="form-control colorpicker colorpicker-componentr" id="color" name="color" placeholder="Enter Color Code #ffffff">
                                        @error('color')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6 ml-3 mt-5">
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
                    <h4 class="card-title">{{ __(' Leave Status List') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                
                                <thead  class="text-primary">
                                    <tr>
                                    <th>Id</th>
                                    <th> Name</th>
                                    <th> Value</th>
                                    <th> color</th>
                                    @if(in_array('update_leave_status', $user_permisions ) || in_array('delete_leave_status', $user_permisions ) )
                                    <th>Action</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach($leaveStatus as $value)
                                    @php $i++; @endphp
                                        <tr>
                                            <td>@php echo $i; @endphp</td>
                                            <td>{{ $value->name }}</td> 
                                            <td>{{ $value->value }}</td> 
                                        <td style="background-color:{{ $value->color }}"> </td>
                                            <td class="td-actions  text-right row ml-auto">
                                            @if( in_array('update_leave_status', $user_permisions ) )
                                                <a href="{{route('leave-status.edit',[$value->id])}}" rel="tooltip" class="btn btn-success"><i class="material-icons">edit</i></a>
                                            @endif
                                            @if( in_array('delete_leave_status', $user_permisions ) )
                                                <form  method="post" action="{{route('leave-status.destroy',[$value->id])}}"> 
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

@endsection
@push('js')
<script type="text/javascript">
  $('.colorpicker').colorpicker({});
</script>
@endpush