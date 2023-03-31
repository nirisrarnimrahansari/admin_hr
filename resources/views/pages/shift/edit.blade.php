@extends('layouts.app', ['activePage' => 'shift', 'titlePage' => __('')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
               <form  method="post" action="{{route('shift.update', [$shift->id])}}"> 
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Update Shifting Time') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                              <div class="col-lg-6 mt-3">
                                    <label for="name" class="col-form-label">Name</label>
                                    <input type="text" value="{{$shift->name}}" class="form-control" name="name" id="name" placeholder=" Name"  >
                                    @error('name')
                                       <span class="text-danger">{{$message}}</span>
                                    @enderror
                              </div>
                              <div class="col-lg-6 mt-3">
                                    <label for="login_time" class=" col-form-label">Login</label>
                                    <input type="time" value="{{$shift->login_time}}" class="form-control" name="login_time" id="login_time"  placeholder="shifting Time" >
                                    @error('login_time')
                                       <span class="text-danger">{{$message}}</span>
                                    @enderror
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-6 mt-3">
                                    <label for="logout_time" class="col-form-label">Logout</label>
                                    <input type="time" class="form-control" value="{{$shift->logout_time}}" name="logout_time" id="logout_time" placeholder="Logout Time" >
                                    @error('logout_time')
                                       <span class="text-danger">{{$message}}</span>
                                    @enderror
                              </div>
                              <div class="col-lg-6 mt-3">
                                    <label for="buffer_time" class="col-form-label">Buffer Time</label>
                                    <input type="number" value="{{$shift->buffer_time}}" class="form-control" name="buffer_time" id="buffer_time" placeholder="Buffer Time" >
                                    @error('buffer_time')
                                       <span class="text-danger">{{$message}}</span>
                                    @enderror
                              </div>
                           </div>
                           <div class="form-group col-lg-6 mt-5">
                              <button type="submit" class="btn btn-primary">Update</button>
                              <a class="btn btn-md fs-1 btn-light" href="/shift" >Cancel</a>
                           </div>
                        </div>
                     </div>

               </form>
            </div>
         </div>
   </div>
</div>
@endsection
