@extends('layouts.app', ['activePage' => 'holiday', 'titlePage' => __('')])

@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_holidays', $user_permisions ) )
<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('holiday.store')}}"> 
                        @csrf
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Add Holiday') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                            <label for="holiday_name"  class="col-form-label"> Holiday Name</label>
                                            <input type="text" class="form-control" id="holiday_name" name="holiday_name" placeholder="Enter Holiday Name">
                                            @error('holiday_name')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                    </div>
                                    <div class="col-lg-6">
                                            <label for="holiday_date"  class="col-form-label"> Holiday Date</label>
                                            <input type="date" class="form-control" id="holiday_date" name="holiday_date" placeholder="Enter Holiday Date">
                                            @error('holiday_date')
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
                        <h4 class="card-title">{{ __(' Holiday List') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    
                                    <thead  class="text-primary">
                                        <tr>
                                        <th>Id</th>
                                        <th>Holiday Name</th>
                                        <th>Holiday Date</th>
                                        @if(in_array('update_holidays', $user_permisions ) || in_array('delete_holidays', $user_permisions ) )
                                        <th>Action</th>
                                        @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=0; @endphp
                                        @foreach($holiday as $value)
                                        @php $i++; @endphp
                                        <tr>
                                                <td>@php echo $i; @endphp</td>
                                                <td>{{ $value->holiday_name }}</td> 
                                                <td>{{ date('d M Y', strtotime($value->holiday_date)) }}</td> 
                                                <td class="td-actions  text-right row ml-auto">
                                                @if( in_array('update_holidays', $user_permisions ) )
                                                    <a href="{{route('holiday.edit',[$value->id])}}" rel="tooltip" class="btn btn-success"><i class="material-icons">edit</i></a>
                                                @endif
                                                @if( in_array('delete_holidays', $user_permisions ) )
                                                    <form  method="post" action="{{route('holiday.destroy',[$value->id])}}"> 
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


