@extends('layouts.app', ['activePage' => 'leave-status', 'titlePage' => __('')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form  method="post" action="{{route('leave-status.update', [$leaveStatus->id])}}">
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Update Leave Status') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class=" col-lg-6">
                                        <label for="name"  class="col-form-label">  Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{$leaveStatus->name}}" >
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class=" col-lg-6">
                                        <label for="value"  class="col-form-label">  Value</label>
                                        <input type="text" class="form-control" id="value" name="value"  value="{{$leaveStatus->value}}">
                                        @error('value')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-lg-6">
                                        <label for="color" class="col-form-label">Color Code</label>
                                        <input type="text" id="cp2" class="form-control colorpicker colorpicker-componentr" id="color" name="color"  value="{{$leaveStatus->color}}">
                                        @error('color')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class="form-group col-lg-6 ml-3 mt-5">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a class="btn btn-md fs-1 btn-light" href="/leave-status" >Cancel</a>
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
@push('js')
<script type="text/javascript">
  $('.colorpicker').colorpicker({});
</script>
@endpush