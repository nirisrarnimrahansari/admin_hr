@extends('layouts.app', ['activePage' => 'employee-list', 'titlePage' => __('')])
@section('content')
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <form  method="post" action="{{route('employee.update', [$employees->id])}}"> 
                  @csrf
                  @method('PATCH')
                        <div class="card">
                           <div class="card-header card-header-primary">
                              <h4 class="card-title">{{ __('Update Employee Details Form') }}</h4>
                           </div>
                           <div class="card-body">
                              <div class="row g-3">
                                 <div class=" col-lg-6">
                                       <label for="name">Name</label>
                                       <input type="text" class="form-control" value="{{$employees->name}}" id="name" name="name" >
                                          @error('name')
                                             <span class="text-danger">{{$message}}</span>
                                          @enderror
                                 </div>
                                 <div class="col-md-6">               
                                       <label for="father_name">Father Name</label>
                                       <input type="text" class="form-control" value="{{$employees->father_name}}" id="father_name" name="father_name" >
                                       @error('father_name')
                                                   <span class="text-danger">{{$message}}</span>
                                       @enderror
                                 </div>
                              </div>
                           <div class="row mt-3">
                              <div class="col-md-12">
                                 <label for="select_id">Select ID</label>
                                 <div class="row ">
                                    <div class="col-md-3">
                                       <div class="form-check form-check-radio form-check-inline">
                                          <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="select_id" id="select_id" value="adhar" @php echo $employees->select_id == "adhar" ? "checked" : ""; @endphp>
                                             Adhar Card<span class="circle"> <span class="check"></span></span>
                                          <i class="input-helper"></i></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-check">
                                          <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="select_id" id="select_id" value="voter id" @php echo $employees->select_id == "voter id" ? "checked" : ""; @endphp>
                                             Voter ID <span class="circle"> <span class="check"></span></span>
                                          <i class="input-helper"></i></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-check">
                                          <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="select_id" id="select_id" value="driving liecence" @php echo $employees->select_id == "driving liecence" ? "checked" : ""; @endphp>
                                             Driving Liecence <span class="circle"> <span class="check"></span></span>
                                          <i class="input-helper"></i></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-check">
                                          <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="select_id" id="select_id" value="passport" @php echo $employees->select_id == "passport" ? "checked" : ""; @endphp>
                                          Passport <span class="circle"> <span class="check"></span></span>
                                          <i class="input-helper"></i></label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row mt-3">
                              <div class="col-12">
                                 <label for="id_proof" class="form-label">ID Proof</label>  
                              <!-- <input class="form-control"  data-preview="holder" type="file"  accept=".xls,.xlsx, .jpg, .jpeg, .bmp, .png" id="id_proof" name="id_proof" > -->
                              <div class="input-group">
                                    <span class="">
                                       <a data-input="thumbnail-id_proof" data-preview="preview-id_proof" class="lfm btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> CHOOSE
                                          </a>
                                    </span>
                                    <input id="thumbnail-id_proof" class=" choose_input form-control" value="{{$employees->id_proof}}" type="text" name="id_proof" readonly>
                              </div>
                                 <div id="preview-id_proof" style="margin-top:15px;max-height:100px;">
                                 <img src= "{{$employees->id_proof}}" style="margin-top:15px;max-height:100px;" />
                              </div>
                                 <!-- @error('id_proof')
                                    <span class="text-danger">{{$message}}</span>
                                 @enderror -->
                              </div>
                           </div>
                           <div class="row mt-3">
                              <div class="col-12">
                                 <label for="upload_pan_card" class="form-label">Upload Pan Card</label>
                                 <div class="input-group">
                                    <span class="">
                                       <a data-input="thumbnail-pancard" data-preview="preview-pancard"  class="lfm btn btn-md btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> CHOOSE
                                          </a>
                                    </span>
                                    <input id="thumbnail-pancard" class="choose_input form-control" value="{{$employees->upload_pan_card}}" type="text" name="upload_pan_card" readonly>
                              </div>
                                 <div id="preview-pancard" value="" style="margin-top:15px;max-height:100px;">
                                 <img src= "{{$employees->upload_pan_card}}" style="margin-top:15px;max-height:100px;" />
                                 </div>
                                 <!-- @error('upload_pan_card')
                                    <span class="text-danger">{{$message}}</span>
                                 @enderror -->
                              </div>
                           </div>
                           <div class="row mt-5">
                              <div class="col-lg-6">
                                    <label for="pan_number" class="form-label">Pan Number</label>
                                    <input class="form-control" type="text" value="{{$employees->pan_number}}" id="pan_number" name="pan_number" >
                                    @error('pan_number')
                                          <span class="text-danger">{{$message}}</span>
                                    @enderror
                                 </div>
                                 <div class="col-lg-6">
                                    <label for="designation_id">Designation</label>
                                       <select class="form-control" id="designation_id" name="designation_id">
                                          <option value="{{$employees->designation_id}}" disabled selected>--select designation--</option>
                                          @foreach($designation as $value)
                                             <option value="{{ $value->id}}" {{ $value->id == $employees->designation_id ? 'selected' : '' }}>{{ $value->name }}</option>
                                          @endforeach 
                                    </select>
                                    @error('designation_id')
                                          <span class="text-danger">{{$message}}</span>
                                    @enderror
                                 </div>
                           </div>
                           <div class="row mt-3">
                              <div class="col-lg-6 ">
                                 <label for="email_id">Email ID (Un Official)</label>
                                 <input class="form-control" value="{{$employees->email_id}}" type="email" id="email_id" name="email_id">
                                 @error('email_id')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror
                              </div>
                              <div class="col-lg-6">
                                 <label for="whatsapp_no"> Whats'app Number</label>
                                 <input class="form-control" value="{{$employees->whatsapp_no}}" type="number" id="whatsapp_no" name="whatsapp_no">
                                 @error('whatsapp_no')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror
                              </div>
                           </div>
                           <div class="row mt-3">
                              <div class="col-lg-6">
                                 <label for="dob">Date of Birth</label>
                                 <input class="form-control" value="{{$employees->dob}}" type="date" id="dob" name="dob" >
                                 @error('dob')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror 
                              </div>
                              <div class="col-lg-6"> 
                                 <label for="joining_date">Date of Joinnig</label>
                                 <input class="form-control" value="{{$employees->joining_date}}" type="date" id="joining_date" name="joining_date" >
                                 @error('joining_date')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror 
                              </div>
                           </div>   
                           <div class="row mt-3">
                              <div class="col-lg-6"> 
                                 <label for="basic_salary">Basic Salary</label>
                                 <input class="form-control" value="{{$employees->basic_salary}}" type="number" id="basic_salary" name="basic_salary" >
                                 @error('basic_salary')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror
                              </div>
                              <div class="col-lg-6"> 
                                 <label for="basic_salary_ed">Basic Salary Effective Date</label>
                                 <input class="form-control" value="{{$employees->basic_salary_ed}}" type="date" id="basic_salary_ed" name="basic_salary_ed" >
                        
                              </div>
                           </div>
                           <div class="row mt-3">
                                       <div class="col-lg-3 ">
                                          <label for="shift_id">Shift</label>
                                          <select class="form-control" id="shift_id" name="shift_id">
                                             <option value="{{$employees->shift_id}}" disabled selected>--select designation--</option>
                                             @foreach($shift as $value)
                                             <option value="{{ $value->id}}" {{ $value->id == $employees->shift_id ? 'selected' : '' }}>{{ $value->name }}</option>
                                             @endforeach 
                                             </select>
                                             @error('shift_id')
                                                <span class="text-danger">{{$message}}</span>
                                             @enderror
                                       </div>
                                 <div class="col-lg-3 ">
                                    <label for="shift_ed">Shift  Effective Date</label>
                                    <input class="form-control" value="{{$employees->shift_ed}}" type="date" id="shift_ed" name="shift_ed" >
                                    @error('shift_ed')
                                          <span class="text-danger">{{$message}}</span>
                                    @enderror
                                 </div>
                              <div class="col-lg-3 "> 
                                    <label class="col-form-label" for="type">Type</label>
                                    <div class="form-check">
                                          <label class="form-check-label">
                                          <input type="radio" class="form-check-input" name="type" id="type" value="Probation" value="Permanent" @php echo $employees->type == "Probation" ? "checked" : ""; @endphp>
                                          Probation<span class="circle"> <span class="check"></span></span>
                                          <i class="input-helper"></i></label>
                                    </div>
                              </div>
                              <div class="col-lg-3 mt-5">
                                 <div class="form-check">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="type" id="type" value="Permanent"  @php echo $employees->type == "Permanent" ? "checked" : ""; @endphp>
                                          Permanent<span class="circle"> <span class="check"></span></span>
                                       <i class="input-helper"></i></label>
                                 </div>
                              </div>
                           </div>
                           <div class="row mt-3">
                              <div class="col-lg-6">
                                    <label for="permanent_date">Permanent Date</label>
                                    <input class="form-control" value="{{$employees->permanent_date}}" type="date" id="permanent_date" name="permanent_date" >
                                 
                                 </div>
                                 <div class="col-lg-3">
                                       <label for="casual_leave">Casual Leave </label>
                                       <input class="form-control" value="{{$employees->casual_leave}}" type="text" id="casual_leave" name="casual_leave" >
                                       
                                    </div>
                                 <div class="col-lg-3">
                                       <label for="earn_leave">Earn Leave </label>
                                       <input class="form-control" value="{{$employees->earn_leave}}" type="text" id="earn_leave" name="earn_leave">
                                    
                                 </div>
                           </div>
                           <div class="row mt-3">
                                 <div class="col-lg-6">
                                             <label for="department_id">Department</label>
                                             <select class="form-control" id="department_id" name="department_id">
                                                @foreach($department as $value)
                                                   <option value="{{ $value->id}}" {{ $value->id == $employees->department_id ? 'selected' : '' }}>{{ $value->department_name }}</option>
                                                @endforeach
                                          </select>
                                          @error('department_id')
                                             <span class="text-danger">{{$message}}</span>
                                          @enderror 
                                 </div>
                                 <div class="col-lg-6">
                                       <label for="biometric_id">Biometric ID </label>
                                       <input class="form-control" value="{{$employees->biometric_id}}" type="number" id="biometric_id" name="biometric_id" >
                                       @error('biometric_id')
                                          <span class="text-danger">{{$message}}</span>
                                       @enderror
                                 </div>
                           </div>
                           <div class="row">
                              <div class="col-12 text-center">
                                 <button type="submit"  name="submit"  class="btn btn-md btn-primary" ><b>Update</b></button>
                                 <a class="btn btn-md fs-1 btn-light" href="/employee" >Cancel</a>
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
<script>
   jQuery('.lfm').filemanager('image', {prefix:'{{route("unisharp.lfm.show")}}'});
</script>
@endpush       
            