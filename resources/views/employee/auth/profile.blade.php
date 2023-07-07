<x-user-home-layout>
<div class="main-content">
            <div class="container-fluid">
                     <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="breadcome-list">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="breadcome-heading">
                       <h1>Profile</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <ul class="breadcome-menu">
                        <li><a href="{{ route('user.home') }}">Home</a> <span class="bread-slash">/</span>
                        </li>
                        <li><span class="bread-blod">Profile</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!--  -->
        </div>
    </div>
                        <!-- pro -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form method="post" action="{{ route('user.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                                @csrf
                                <div class="form_section">
                                    <div class="row">
                                        <div class="col-md-12"> <h1>Profile Detail</h1></div> 
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                {{ Form::select('role',$role,[($data->userRole->role->slug) ?? ''],['class'=>'form-control','id'=>'role','placeholder'=>'Choose Role','disabled'=>true])}}
                                                <span class="text-danger">{{ $errors->first('role') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="username">Name</label>
                                                {{ Form::text('name',$data->name,['class'=>'form-control','id'=>'username','placeholder'=>'Name'])}}
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="contact">Contact</label>
                                                {{ Form::number('contact', $data->mobile,['class'=>'form-control','id'=>'contact','placeholder'=>'Contact'])}}
                                                <span class="text-danger">{{ $errors->first('contact') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                {{ Form::email('email',$data->email,['class'=>'form-control','id'=>'email','placeholder'=>'Email'])}}
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                {{ Form::text('address',($data->userAddress->address ?? ''),['class'=>'form-control','id'=>'address','placeholder'=>'Address'])}}
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="category">State</label>
                                                {{ Form::select('state',$state,[$data->userAddress->userState->slug ?? ''],['class'=>'form-control address','id'=>'state','placeholder'=>'Choose State'])}}
                                                <span class="text-danger">{{ $errors->first('state') }}</span>
                                            </div>
                                        </div>

                                         <div class="col-md-3">
                                            <div class="form-group city">
                                                <label for="city">City</label>
                                                {{ Form::select('city',$city,[$data->userAddress->userCity->slug ?? ''],['class'=>'form-control address','id'=>'city','placeholder'=>'Choose City'])}}
                                                <span class="text-danger">{{ $errors->first('city') }}</span>
                                            </div>
                                        </div>
                                         <div class="col-md-3">
                                            <div class="form-group taluk">
                                                <label for="taluk">Taluk</label>
                                                {{ Form::select('taluk',$taluk,[$data->userAddress->userTaluk->slug ?? ''],['class'=>'form-control address','id'=>'taluk','placeholder'=>'Choose Taluk'])}}
                                                <span class="text-danger">{{ $errors->first('taluk') }}</span>
                                            </div>
                                        </div>
                                         <div class="col-md-3">
                                            <div class="form-group pincode">
                                                <label for="pincode">Pin code</label>
                                                {{ Form::select('pincode',$pincode,[$data->userAddress->userPincode->slug ?? ''],['class'=>'form-control','id'=>'pincode','placeholder'=>'Choose Pin code'])}}
                                                <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="office_no">Office number</label>
                                                {{ Form::number('office_no', $data->office_no,['class'=>'form-control','id'=>'office_no','placeholder'=>'Office number'])}}
                                                <span class="text-danger">{{ $errors->first('office_no') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="office_email">Office Email</label>
                                                {{ Form::email('office_email',$data->office_email,['class'=>'form-control','id'=>'office_email','placeholder'=>'Office Email'])}}
                                                <span class="text-danger">{{ $errors->first('office_email') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="designation">Designation</label>
                                                {{ Form::text('designation',$data->designation,['class'=>'form-control','id'=>'designation','placeholder'=>'Designation'])}}
                                                <span class="text-danger">{{ $errors->first('designation') }}</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="form_section">
                                    <div class="row">
                                        <div class="col-md-12"> <h1>Attachment</h1></div> 
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="pan_file">Pan card</label>
                                                {{ Form::file('pan_file',['class'=>'form-control','id'=>'pan_file','placeholder'=>'Pan card'])}}
                                                <span class="text-danger">{{ $errors->first('pan_file') }}</span>
                                            </div>
                                            @if($data->pan_file)
                                               <a href="{{ asset('public/'.$data->pan_file) }}" title="{{ $data->pan_file }}" target="_blank">
                                                    {!! Html::decode(Helper::getDocType('public/', $data->pan_file)) !!}
                                                </a>
                                            @endif
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="aadhar_file">Aadhar card</label>
                                                {{ Form::file('aadhar_file',['class'=>'form-control','id'=>'aadhar_file','placeholder'=>'Aadhar card'])}}
                                                <span class="text-danger">{{ $errors->first('aadhar_file') }}</span>
                                            </div>
                                            @if($data->aadhar_file)
                                               <a href="{{ asset('public/'.$data->aadhar_file) }}" title="{{ $data->aadhar_file }}" target="_blank">
                                                    {!! Html::decode(Helper::getDocType('public/', $data->aadhar_file)) !!}
                                                </a>
                                            @endif
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="resume_file">Resume File</label>
                                                {{ Form::file('resume_file',['class'=>'form-control','id'=>'resume_file','placeholder'=>'Resume File'])}}
                                                <span class="text-danger">{{ $errors->first('resume_file') }}</span>
                                            </div>
                                            @if($data->resume_file)
                                               <a href="{{ asset('public/'.$data->resume_file) }}" title="{{ $data->resume_file }}" target="_blank">
                                                    {!! Html::decode(Helper::getDocType('public/', $data->resume_file)) !!}
                                                </a>
                                            @endif
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="resume_file">Other File</label>
                                                {{ Form::file('other_file',['class'=>'form-control','id'=>'other_file','placeholder'=>'Other File'])}}
                                                <span class="text-danger">{{ $errors->first('other_file') }}</span>
                                            </div>
                                            @if($data->other_file)
                                               <a href="{{ asset('public/'.$data->other_file) }}" title="{{ $data->other_file }}" target="_blank">
                                                    {!! Html::decode(Helper::getDocType('public/', $data->other_file)) !!}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form_section">
                                    <div class="row">
                                        <div class="col-md-12"> <h1>Additional information</h1></div> 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{ Form::textarea('additional_information',$data->additional_information,['class'=>'form-control','id'=>'designation','placeholder'=>'Additional information','rows'=>2])}}
                                                <span class="text-danger">{{ $errors->first('additional_information') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form_btnbox profile_btn">
                                        <button type="submit" class="btn btn-custon-save btn-primary">{{ __('Save') }}</button>
                                    </div> 
                                </div>     
                            </form>
                        </div>
                         
                        <!-- end pro -->
                        <!-- pass -->
                        <div class="col-md-12">
                            <form method="post" action="{{ route('user.password.update') }}" class="mt-6 space-y-6">
                                @csrf

                                <div class="form_section bottomspace">
                                    <div class="row">
                                        <div class="col-md-12"> <h1>Change Password</h1></div> 
                                        <div class="col-md-4"> 
                                            <div class="form-group">
                                                <label for="password">Current Password</label>
                                                {{ Form::password('current_password',['class'=>'form-control','id'=>'password','placeholder'=>'Current Password'])}}
                                                <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="new_password">New Password</label>
                                                {{ Form::password('new_password',['class'=>'form-control','id'=>'new_password','placeholder'=>'New Password'])}}
                                                <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="confirm_password">Confirm Password</label>
                                                {{ Form::password('confirm_password',['class'=>'form-control','id'=>'confirm_password','placeholder'=>'Confirm Password'])}}
                                                <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form_btnbox profile_btn">
                                            <button type="submit" class="btn btn-custon-save btn-primary">{{ __('Change') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- emd pass -->
                    </div>
                
            </div>
        </div>
</x-user-home-layout>
 <script type="text/javascript">
  $(document).ready(function () {
    $(document).on('change', '.address', function() {
      var slug = $(this).val();
      var type = $(this).attr('id');
      if (slug && type) {
          var url="{{ route('user.ajaxAddressDropdown') }}";
            $.ajax({
              type:"POST",
              url:url,
              data:{slug:slug , _token: '{{csrf_token()}}',type:type},
              beforeSend: function(){
              // $('#preloader').show();
              },
              success:function(response){
                if (type=='state') {
                    $('#taluk,#pincode').find('option').remove();
                    $('.city').empty().html(response);
                }
                if (type=='city') {
                    $('#pincode').find('option').remove();
                    $('.taluk').empty().html(response);
                }
                if (type=='taluk') {
                    $('.pincode').empty().html(response);
                }
               // $('#preloader').hide();
              }
            });
      }else{
        $('#city,#taluk,#pincode').find('option').remove();
      }
    });
  });
</script>