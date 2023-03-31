@extends('layouts.app', ['activePage' => 'generate_salary-email_format', 'titlePage' => __('')])

@section('content') 
 <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" enctype="multipart/form-data" action="{{route('email-format.update', [$email->id])}}"> 
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Update Email Format') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">                                  
                                <label for="subject" class="col-sm-2 col-form-label">{{ __('Subject') }}</label>
                                <div class="col-sm-7">
                                    <input  class="form-control" value="{{$email->subject}}" type="text" name="subject" id="subject" placeholder="Add subject ">
                                    @error('subject')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">                                  
                                <label for="content" class="col-sm-2 col-form-label" >{{ __('Content') }}</label>
                                <div class="col-sm-7" style="width:100%;height:100%; !important" >
                                    <textarea class="form-control" type="text" name="content" id="content" onKeyPress placeholder="Add Description" >{!! $email->content !!}
                                    </textarea>
                                    @error('content')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                        <span class='btn btn-secondary' onclick="copyToClipboard('%name%')">%name%</span>
                                        <span class='btn btn-secondary' onclick="copyToClipboard('%month%')">%month%</span>
                                        <span class='btn btn-secondary' onclick="copyToClipboard('%year%')">%year%</span>
                                        <span class='btn btn-secondary' onclick="copyToClipboard('%basic_salary%')">%basic_salary%</span>
                                        <span class='btn btn-secondary' onclick="copyToClipboard('%final_salary%')">%final_salary%</span>
                                </div> 
                            </div>
                        </div> 
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Update Message</button>
                                <a class="btn btn-md fs-1 btn-light" href="/email-format" >Cancel</a>
                                
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
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<script>
function copyToClipboard(value) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val(value).select();
  document.execCommand("copy");
  $temp.remove();
}
</script>

@endpush