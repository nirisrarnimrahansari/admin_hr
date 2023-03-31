@extends('layouts.app', ['activePage' => 'employee-add', 'titlePage' => __('')])

@section('content')

<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <form  method="post" enctype="multipart/form-data" action="{{route('employee.store')}}"> 
                    @csrf
                     <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Employee Registration Form') }}</h4>
                            <p class="card-description"> Employee Registration</p>
                        </div>
                        <div class="card-body">
                           <div class="row g-3">
                              <div class="col-md-6">
                                 <label for="name">Name</label>
                                 <input type="text" class="form-control" value="{{old('name')}}" placeholder="Enter Your Full Name" id="name" name="name" >
                                 @error('name')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror
                              </div>
                              <div class="col-md-6">               
                                 <label for="father_name">Father Name</label>
                                 <input type="text" class="form-control" value="{{old('father_name')}}" placeholder="Enter Your Father Name" id="father_name" name="father_name" >
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
                                             <input type="radio"class="form-check-input " name="select_id" id="select_id" {{old('select_id') == "adhar" ? 'checked': ""}} value="adhar" checked="">
                                             Adhar Card<span class="circle"> <span class="check"></span></span>
                                          <i class="input-helper"></i></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-check">
                                          <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="select_id" id="select_id" {{old('select_id') == "voter id" ? 'checked': ""}} value="voter id" checked="">
                                             Voter ID <span class="circle"> <span class="check"></span></span>
                                          <i class="input-helper"></i></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-check">
                                          <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="select_id" id="select_id" {{old('select_id') == "driving liecence" ? 'checked': ""}} value="driving liecence" checked="">
                                             Driving Liecence <span class="circle"> <span class="check"></span></span>
                                          <i class="input-helper"></i></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="form-check">
                                          <label class="form-check-label">
                                             <input type="radio" class="form-check-input" name="select_id" id="select_id" {{old('select_id') == "passport" ? 'checked': ""}} value="passport" checked="">
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
                              <div class="input-group">
                                    <span class="">
                                       <a data-input="thumbnail-id_proof" data-preview="preview-id_proof" class="lfm btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> CHOOSE
                                          </a>
                                    </span>
                                    <input id="thumbnail-id_proof" class="choose_input form-control"  value="{{old('id_proof')}}" type="text" name="id_proof" readonly>
                              </div>
                                 <div id="preview-id_proof" style="margin-top:15px;max-height:100px;"></div>
                                 @error('id_proof')
                                    <span class="text-danger">{{$message}}</span>
                                 @enderror
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
                                    <input id="thumbnail-pancard" class="choose_input form-control" type="text"  value="{{old('upload_pan_card')}}" name="upload_pan_card" readonly>
                              </div>
                                 <div id="preview-pancard" style="margin-top:15px;max-height:100px;"></div>
                                 @error('upload_pan_card')
                                    <span class="text-danger">{{$message}}</span>
                                 @enderror
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-6 mt-3">
                                    <label for="pan_number" class="form-label">Pan Number</label>
                                    <input class="form-control" type="text" value="{{old('pan_number')}}" id="pan_number" name="pan_number" placeholder="Pan Card Number" >
                                    @error('pan_number')
                                          <span class="text-danger">{{$message}}</span>
                                    @enderror
                                 </div>
                              <div class="col-lg-6 mt-3">
                                    <label for="designation_id">Designation</label>
                                       <select class="form-control" id="designation_id" name="designation_id">
                                          <option value=""  disabled selected>--Select Designation Name--</option>
                                          @foreach($designation as $value)
                                             <option value="{{$value->id}}" {{old('designation_id') == $value->name ? 'selected': ""}}>{{$value->name}}</option>
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
                                 <input class="form-control" value="{{old('email_id')}}" type="email" id="email_id" name="email_id" placeholder="Enter your Email Id" >
                                 @error('email_id')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror
                              </div>
                              <div class="col-lg-6">
                                 <label for="whatsapp_no"> Whats'app Number</label>
                                 <input class="form-control" value="{{old('whatsapp_no')}}" type="number" id="whatsapp_no" name="whatsapp_no" placeholder="Whats'app number" >
                                 @error('whatsapp_no')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror
                              </div>
                           </div>
                           <div class="row mt-3">
                              <div class="col-lg-6">
                                 <label for="dob">Date of Birth</label>
                                 <input class="form-control" value="{{old('dob')}}" type="date" id="dob" name="dob" >
                                 @error('dob')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror 
                              </div>
                              <div class="col-lg-6"> 
                                 <label for="joining_date">Date of Joinnig</label>
                                 <input class="form-control" value="{{old('joining_date')}}" type="date" id="joining_date" name="joining_date" >
                                 @error('joining_date')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror 
                              </div>
                           </div>   
                           <div class="row mt-3">
                              <div class="col-lg-6"> 
                                 <label for="basic_salary">Basic Salary</label>
                                 <input class="form-control" value="{{old('basic_salary')}}" type="number" id="basic_salary" name="basic_salary" >
                                 @error('basic_salary')
                                          <span class="text-danger">{{$message}}</span>
                                 @enderror
                              </div>
                              <div class="col-lg-6"> 
                                 <label for="basic_salary_ed">Basic Salary Effective Date</label>
                                 <input class="form-control" value="{{old('basic_salary_ed')}}" type="date" id="basic_salary_ed" name="basic_salary_ed" >
                        
                              </div>
                           </div>
                           <div class="row">
                                 <div class="col-lg-3 mt-3">
                                          <label for="shift_id">Shift</label>
                                          <select class="form-control" id="shift_id" name="shift_id">
                                             <option value="" disabled selected>--Select Shifting Name--</option>
                                             @foreach($shift as $value)
                                                <option value="{{$value->id}}" {{old('shift_id') == $value->name ? 'selected': ""}}>{{$value->name}}</option>
                                             @endforeach 
                                             </select>
                                             @error('shift_id')
                                                <span class="text-danger">{{$message}}</span>
                                             @enderror
                                 </div>
                                 <div class="col-lg-3 mt-3">
                                    <label for="shift_ed">Shift  Effective Date</label>
                                    <input class="form-control" value="{{old('shift_ed')}}" type="date" id="shift_ed" name="shift_ed" >
                                    @error('shift_ed')
                                          <span class="text-danger">{{$message}}</span>
                                    @enderror
                                 </div>
                              <div class="col-lg-3 "> 
                                    <label class="col-form-label" for="type">Type</label>
                                    <div class="form-check">
                                          <label class="form-check-label">
                                          <input type="radio" class="form-check-input" name="type" id="type" {{old('type') == "Probation" ? 'checked': ""}}  value="Probation" checked="">
                                          Probation<span class="circle"> <span class="check"></span></span>
                                          <i class="input-helper"></i></label>
                                    </div>
                              </div>
                              <div class="col-lg-3 mt-5">
                                 <div class="form-check">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="type" id="type" value="Permanent"  {{old('type') == "Permanent" ? 'checked': ""}} checked="">
                                          Permanent<span class="circle"> <span class="check"></span></span>
                                       <i class="input-helper"></i></label>
                                 </div>
                              </div>
                           </div>
                           <div class="row mt-3">
                              <div class="col-lg-6">
                                    <label for="permanent_date">Permanent Date</label>
                                    <input class="form-control" value="{{old('permanent_date')}}" type="date" id="permanent_date" name="permanent_date" >
                                 
                                 </div>
                                 <div class="col-lg-3">
                                       <label for="casual_leave">Casual Leave </label>
                                       <input class="form-control" value="{{old('casual_leave')}}" type="text" id="casual_leave" name="casual_leave" placeholder= CL >
                                       
                                    </div>
                                 <div class="col-lg-3">
                                       <label for="earn_leave">Earn Leave </label>
                                       <input class="form-control" value="{{old('earn_leave')}}" type="text" id="earn_leave" name="earn_leave" placeholder= EL >
                                    
                                 </div>
                           </div>
                           <div class="row">
                                 <div class="col-lg-6 mt-3">
                                       <label for="department_id">Department</label>
                                       <select class="form-control" id="department_id" name="department_id" >
                                          <option  value="" disabled selected>--Select Department Name--</option>
                                          @foreach($department as $value)
                                             <option value="{{$value->id}}" {{old('department_id') == $value->department_name ? 'selected': ""}}>{{$value->department_name}}</option>
                                          @endforeach 
                                       </select>
                                       </select>
                                       @error('department_id')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror 
                                 </div>
                                 <div class="col-lg-6 mt-3">
                                       <label for="biometric_id">Biometric ID </label>
                                       <input class="form-control" value="{{old('biometric_id')}}" type="number" id="biometric_id" name="biometric_id" >
                                       @error('biometric_id')
                                          <span class="text-danger">{{$message}}</span>
                                       @enderror
                                 </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-12 text-center">                      
                                    <label class="form-check-label">

                                    <input type="checkbox" name="agreement_condition" class="form-check-input" >
                                    I agree with all Term & Conditions
                                    </label>                      
                              </div>
                              @error('agreement_condition')
                                          <span class="text-danger col-12 text-center">{{$message}}</span>
                                       @enderror
                              <div class="col-12 text-center">
                                 <button type="submit"  name="submit"  class="btn btn-md btn-primary" ><b>Submit</b></button>
                                 <a class="btn btn-md fs-1 btn-light" href="/employee" >Cancel</a>
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
<script>
   jQuery('.lfm').filemanager('image', {prefix:'{{route("unisharp.lfm.show")}}'});
</script>
@endpush
