@extends('layouts.app', ['activePage' => 'user-add', 'titlePage' => __('')])

@section('content')

<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
               <form  method="post" action="{{route('user.update', [$user->id])}}" enctype="multipart/form-data"> 
                     @csrf
                        @method('PATCH')
                        <div class="card">
                           <div class="card-header card-header-primary">
                              <h4 class="card-title">{{ __('Update User') }}</h4>
                           </div>
                           <div class="card-body">
                              <div class="row mt-3">
                                    <div class=" col-lg-6">
                                          <label for="name" class=" col-form-label">Add User Name</label>
                                          <input type="text" class="form-control" value="{{$user->name}}" name="name" id="name">
                                          @error('name')
                                             <span class="text-danger">{{$message}}</span>
                                          @enderror
                                    </div>
                                    <div class="col-lg-6">
                                       <label for="email" class=" col-form-label">Add Email Id</label>
                                       <input  class="form-control" value="{{$user->email}}" type="email" name="email" id="email">
                                       @error('email')
                                             <span class="text-danger">{{$message}}</span>
                                       @enderror
                                    </div>
                              </div>   
                              <div class="row mt-3">
                                    <div class="col-lg-6">
                                       <label for="password" class=" col-form-label">Add Password</label>
                                       <input  class="form-control" value="{{$user->password}}" type="password" name="password" id="password"  minlength="8">
                                       @error('password')
                                             <span class="text-danger">{{$message}}</span>
                                       @enderror
                                    </div>
                                    <div class="col-lg-6">
                                       <label for="mobile" class=" col-form-label">Add Mobile</label>
                                       <input  class="form-control" type="tel" value="{{$user->mobile}}" name="mobile" id="mobile"  pattern="[0-9]{3}[0-9]{4}[0-9]{3}">
                                       @error('mobile')
                                             <span class="text-danger">{{$message}}</span>
                                       @enderror
                                    </div>
                              </div>
                              <div class="row mt-3">
                                 <div class="col-lg-6">
                                    <label for="user_r" class=" col-form-label">User Role</label>
                                       <select class="form-control" value="{{old('user_r')}}" id="user_r" name="user_r">
                                          <option value="{{$user->user_r}}" disabled selected>--select user role--</option>
                                                @foreach($user_role as $value)
                                                <option value="{{ $value->id}}" {{ $value->id == $user->user_r ? 'selected' : '' }}>{{ $value->user_name }}</option>
                                                @endforeach  
                                       </select>
                                       @error('user_r')
                                             <span class="text-danger">{{$message}}</span>
                                       @enderror
                                 </div>
                                    <div class="col-lg-6">
                                       <label for="user_occ" class=" col-form-label">Add User Occupation</label>
                                       <select class="form-control" value="{{old('user_occ')}}" id="user_occ" name="user_occ">
                                             <option value="{{$user->user_occ}}" disabled selected>--select designation--</option>
                                                @foreach($designation as $value)
                                                <option value="{{ $value->id}}" {{ $value->id == $user->user_occ ? 'selected' : '' }}>{{ $value->name }}</option>
                                                @endforeach 
                                       </select>
                                       @error('designation_id')
                                                <span class="text-danger">{{$message}}</span>
                                          @enderror
                                    </div>
                              </div>
                              <div class="row mt-3">
                                 <div class="col-lg-12">
                                    <label for="user_image" class="form-label">ID Proof</label>  
                                          <div class="input-group">
                                             <span class="">
                                                   <a data-input="thumbnail-user_image" data-preview="preview-user_image" class="lfm btn btn-primary text-white">
                                                      <i class="fa fa-picture-o"></i> CHOOSE
                                                   </a>
                                             </span>
                                             <input id="thumbnail-user_image" class=" choose_input form-control" value="{{$user->user_image}}" type="text" name="user_image" readonly>
                                          </div>
                                          <div id="preview-user_image" style="margin-top:15px;max-height:100px;"></div>
                                             @error('user_image')
                                                <span class="text-danger">{{$message}}</span>
                                             @enderror
                                          </div>
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <button type="submit" class="btn btn-primary">Update</button>
                                 <a class="btn btn-md fs-1 btn-light" href="/user" >Cancel</a>
                                 
                              </div>
                           </div>
                        </div>
               </form>
            </div>   
         </div>
      </div>
@endsection

@push('js')
<script>
   jQuery('.lfm').filemanager('image', {prefix:'{{route("unisharp.lfm.show")}}'});
</script>
@endpush       
          