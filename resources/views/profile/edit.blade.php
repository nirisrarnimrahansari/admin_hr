@extends('layouts.app', ['activePage' => 'profile', 'titlePage' => __('')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('profile.update') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit Profile') }}</h4>
                <p class="card-category">{{ __('User information') }}</p>
              </div>
              <div class="card-body ">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}"  aria-required="true"/>
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email Address') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required readonly autocomplete="email" autofocus>
                      @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
              
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Mobile Number') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('mobile') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" id="input-mobile" type="text" value="{{ old('mobile', auth()->user()->mobile) }}"  placeholder="{{ __('Your Mobile Number') }}"  aria-required="true"/>
                        @if ($errors->has('mobile'))
                          <span id="mobile-error" class="error text-danger" for="input-mobile">{{ $errors->first('mobile') }}</span>
                        @endif
                      </div>
                    </div>
                </div>
                                    
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Your User Designation') }}</label>
                  <div class="col-sm-7">
                      <select class="form-control" name="user_occ" id="user_occ">
                          <option disabled selected value="{{ old('user_occ', auth()->user()->user_occ) }}"> -- {{ __('Select an option') }} -- </option>
                            @foreach ($designation as $value)
                              <option value="{{ $value->id}}" {{ $value->id ==  auth()->user()->user_occ ? 'selected' : '' }}>{{ $value->name }}</option>
                            @endforeach
                      </select>
                     @if ($errors->has('user_occ'))
                        <span id="user_occ-error" class="error text-danger" for="input-user_occ">{{ $errors->first('user_occ') }}</span>
                      @endif
                  </div>
                </div>
              
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Your Profile Pic') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('user_image') ? ' has-danger' : '' }}">
                          <span class="">
                              <a data-input="thumbnail-user_image" data-preview="preview-user_image" class="lfm btn btn-primary text-white"><i class="fa fa-picture-o"></i> CHOOSE
                              </a>
                          </span>
                          <input class="form-control{{ $errors->has('user_image') ? ' is-invalid' : '' }}" name="user_image" id="input-user_image" type="text" value="{{ old('user_image', auth()->user()->user_image) }}"  readonly aria-required="true"/>
                      </div>
                       <div id="preview-user_image" >
                          <img src= "{{auth()->user()->user_image}}" style="margin-top:5px;max-height:100px;" />
                       </div>
                        @if ($errors->has('user_image'))
                          <span id="user_image-error" class="error text-danger" for="input-user_image">{{ $errors->first('name') }}</span>
                        @endif    
                    </div>
                </div>
              </div>
              

              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('profile.password') }}" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Change password') }}</h4>
                <p class="card-category">{{ __('Password') }}</p>
              </div>
              <div class="card-body ">
                @if (session('status_password'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status_password') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-current-password">{{ __('Current Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" input type="password" name="old_password" id="input-current-password" placeholder="{{ __('Current Password') }}" value="" required />
                      @if ($errors->has('old_password'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('old_password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password">{{ __('New Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="input-password" type="password" placeholder="{{ __('New Password') }}" value="" required />
                      @if ($errors->has('password'))
                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirm New Password') }}" value="" required />
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Change password') }}</button>
              </div>
            </div>
          </form>
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
          