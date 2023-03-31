@extends('layouts.app', ['activePage' => 'user-add', 'titlePage' => __('')])
@section('content')
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_user', $user_permisions ) )

<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
               <form  method="post" action="{{route('user.store')}}" enctype="multipart/form-data" > 
                    @csrf
                     <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Add User') }}</h4>
                        </div>
                        <div class="card-body">
                              <div class="row">
                                 <div class=" col-lg-6">
                                       <label for="name" class=" col-form-label">Add User Name</label>
                                       <input type="text" autocomplete="false" class="form-control" value="{{old('name')}}" name="name" id="name" placeholder="Enter Your Name">
                                       @error('name')
                                          <span class="text-danger">{{$message}}</span>
                                       @enderror
                                 </div>
                                 <div class="col-lg-6">
                                    <label for="email" class=" col-form-label"> Email ID</label>
                                    <input  class="form-control" value="{{old('email')}}" type="email" name="email" id="email" placeholder="Enter Your Email ID" >
                                    @error('email')
                                          <span class="text-danger">{{$message}}</span>
                                    @enderror
                                 </div>
                              </div>   
                              <div class="row mt-3">
                                    <div class="col-lg-6">
                                       <label for="password" class=" col-form-label"> Password</label>
                                       <input  class="form-control" autocomplete="false" value="{{old('password')}}" type="password" name="password" id="password"  minlength="8" placeholder="Enter Your Password">
                                       @error('password')
                                             <span class="text-danger">{{$message}}</span>
                                       @enderror
                                    </div>
                                    <div class="col-lg-6">
                                       <label for="mobile" class=" col-form-label"> Mobile</label>
                                       <input  class="form-control" type="tel" value="{{old('mobile')}}"  name="mobile" id="mobile"  pattern="[0-9]{3}[0-9]{4}[0-9]{3}"  placeholder="Enter Your Mobile Number">
                                       @error('mobile')
                                             <span class="text-danger">{{$message}}</span>
                                       @enderror
                                    </div>
                              </div>
                              <div class="row mt-3">
                                 <div class="col-lg-6">
                                    <label for="user_r" class=" col-form-label">User Role</label>
                                       <select class="form-control" id="user_r" name="user_r">
                                          <option  disabled selected>--Select User Role Type--</option>
                                             @foreach($user_role as $value)
                                                <option value="{{ $value->id}}"  {{ $value->id == old('user_r') ? 'selected' : '' }}>{{ $value->user_name }}</option>
                                             @endforeach 
                                       </select>
                                       @error('user_r')
                                             <span class="text-danger">{{$message}}</span>
                                       @enderror
                                 </div>
                                    <div class="col-lg-6">
                                       <label for="user_occ" class=" col-form-label">Add User Occupation</label>
                                       <select class="form-control" id="user_occ" name="user_occ">
                                             <option value="" disabled selected>--Select Designation--</option>
                                                @foreach($designation as $value)
                                                   <option value="{{$value->id}}" {{ $value->id == old('user_occ') ? 'selected' : '' }}>{{$value->name}}</option>
                                                @endforeach 
                                       </select>
                                       @error('user_occ')
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
                                             <input id="thumbnail-user_image" value="{{old('user_image')}}" class="choose_input form-control" type="text" name="user_image" readonly>
                                          </div>
                                             <div id="preview-user_image" style="margin-top:15px;max-height:100px;"></div>
                                 </div>
                              </div>
                              <div class="col-lg-6 mb-3 ml-2">
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
                    <h4 class="card-title">{{ __('User List') }}</h4>
                </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <div class="material-datatables">
                           <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                 
                              <thead  class="text-primary">
                                 <tr>
                                 <th>ID</th>
                                 <th>Name</th>
                                 <th>Email ID</th>
                                 <th>Mobile No.</th>
                                 <th>User Role</th>
                                 <th>User Occupation</th>
                                 @if(in_array('update_user', $user_permisions ) || in_array('delete_user', $user_permisions ) )
                                 <th>Action</th>
                                 @endif
                                 </tr>
                              </thead>
                              <tbody>
                                 @php $i = 0;  @endphp
                                    @foreach($user as $value)
                                    @php $i++; @endphp
                                       <tr>
                                          <td> @php echo $i; @endphp</td>
                                          <td>{{ $value->name }}</td>
                                          <td>{{ $value->email }}</td>
                                          <td>{{ $value->mobile }}</td>
                                          <td>{{ $value->role_info['user_name'] }}</td>
                                          <td>{{ $value->designation_info['name'] }}</td>
                                          <td class="td-actions  text-right row ml-auto">
                                          @if( in_array('update_user', $user_permisions ) )
                                          <a href="{{route('user.edit',[$value->id])}}" rel="tooltip" class="btn btn-success"><i class="material-icons">edit</i></a>
                                          @endif
                                          @if( in_array('delete_user', $user_permisions ) )
                                                <form  method="post" action="{{route('user.destroy',[$value->id])}}"> 
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
@push('js')
<script>
   jQuery('.lfm').filemanager('image', {prefix:'{{route("unisharp.lfm.show")}}'});
</script>
@endpush
