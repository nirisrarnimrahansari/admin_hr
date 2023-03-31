@extends('layouts.app', ['activePage' => 'generate_salary-offer_letter', 'titlePage' => __('')])

@section('content')  
 
@php 
    $user_permisions = App\Http\Controllers\UserPermissionController::get_user_permissions(Auth()->user()->id);
@endphp
@if( in_array('create_offer_letter', $user_permisions ) )
<div class="content">
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" enctype="multipart/form-data" action="{{route('offer-letter.update', [$offer_letters->id])}}"> 
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Offer Letter Update Format Form') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">                                  
                                <label for="subject" class="col-sm-2 col-form-label">{{ __('Subject') }}</label>
                                <div class="col-sm-7">
                                    <input  class="form-control"  value="{{$offer_letters->subject}}" type="text" name="subject" id="subject">
                                    @error('subject')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">                                  
                                <label for="description" class="col-sm-2 col-form-label" id="container">{{ __('Description') }}</label>
                                <div class="col-sm-7" >
                                    <input  class="form-control" value="{{$offer_letters->description}}" type="text" name="description" id="description" >
                                    @error('description')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">                                  
                                <label for="content" class="col-sm-2 col-form-label" id="container">{{ __('Content') }}</label>
                                <div class="col-sm-7" >
                                     <textarea class="form-control content" type="text" style="resize: none;" name="content" id="content"  onKeyPress rows="10" cols="50" >{!! $offer_letters->content !!}
                                    </textarea>
                                    
                                    @error('content')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <p id="codeCopy1" onclick="copyToClipboard('#codeCopy1')" 
                                 data-bs-placement="top" class='btn btn-secondary' tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" 
                                 data-bs-content="Copy to clipboard" data-bs-original-title="" title=""><span>%name%</span>
                                  <i class="fa fa-copy"></i></p> 

                                  <p id="codeCopy2" onclick="copyToClipboard('#codeCopy2')" 
                                 data-bs-placement="top" class='btn btn-secondary' tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" 
                                 data-bs-content="Copy to clipboard" data-bs-original-title="" title=""><span>%designation%</span>
                                  <i class="fa fa-copy"></i></p>      
                                  
                                  <p id="codeCopy3" onclick="copyToClipboard('#codeCopy3')" 
                                 data-bs-placement="top" class='btn btn-secondary' tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" 
                                 data-bs-content="Copy to clipboard" data-bs-original-title="" title=""><span>%joining_date%</span>
                                  <i class="fa fa-copy"></i></p> 

                                  <p id="codeCopy4" onclick="copyToClipboard('#codeCopy4')" 
                                 data-bs-placement="top" class='btn btn-secondary' tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" 
                                 data-bs-content="Copy to clipboard" data-bs-original-title="" title=""><span>%basic_salary%</span>
                                  <i class="fa fa-copy"></i></p> 

                                  <p id="codeCopy5" onclick="copyToClipboard('#codeCopy5')" 
                                 data-bs-placement="top" class='btn btn-secondary' tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" 
                                 data-bs-content="Copy to clipboard" data-bs-original-title="" title=""><span>%login_time%</span>
                                  <i class="fa fa-copy"></i></p> 
                                 
                                  <p id="codeCopy6" onclick="copyToClipboard('#codeCopy6')" 
                                 data-bs-placement="top" class='btn btn-secondary' tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" 
                                 data-bs-content="Copy to clipboard" data-bs-original-title="" title=""><span>%logout_time%</span>
                                  <i class="fa fa-copy"></i></p> 
                                </div> 
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Message') }}
                                    </button>
                                <a class="btn btn-md fs-1 btn-light" href="/offer-letter" >Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection

@push('js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script type="text/javascript">
 
  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
  })
  function copyToClipboard(element){
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element+' span').text()).select();
    document.execCommand("copy");
    $temp.remove();
    $('.popover-body').html('Copied!');
  }

</script>
@endpush