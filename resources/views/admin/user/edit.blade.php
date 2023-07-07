<x-admin-home-layout>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <!-- <a class="btn btn-custon-four btn-default text-success back" href="{{ route('admin.users') }}" title="Back"><i class="fa fa-arrow-circle-left"></i></a> -->
                              <h1>Edit User</h1>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                </li>
                                <li><a href="{{ route('admin.users') }}">Users</a> <span class="bread-slash">/</span>
                                                    </li>
                                <li><span class="bread-blod">Edit</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                   
                    <!--  -->
                </div>
            </div>

            <form method="post" action="{{ route('admin.updateUser',$data->slug) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    
                        @csrf

                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>User Information</h1></div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        {{-- Form::select('role',$role,[($data->userRole->role->slug) ?? ''],['class'=>'form-control','id'=>'role','placeholder'=>'Choose Role']) --}}
                                        <select name="role" class="form-control" id="role">
                                            <option value="">Choose Role</option>
                                            @forelse($role as $key => $val)
                                                <option value="{{ $key }}" @if($key == (($data->userRole->role->slug) ?? '')) selected @endif>{{ $val }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <span class="text-danger">{{ $errors->first('role') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Name</label>
                                        {{ Form::text('name',$data->name,['class'=>'form-control','id'=>'username','placeholder'=>'Name'])}}
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact">Contact</label>
                                        {{ Form::number('contact', $data->mobile,['class'=>'form-control','id'=>'contact','placeholder'=>'Contact'])}}
                                        <span class="text-danger">{{ $errors->first('contact') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        {{ Form::email('email',$data->email,['class'=>'form-control','id'=>'email','placeholder'=>'Email'])}}
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="password">Passowrd</label>
                                        {{ Form::text('password',($data->original_password ?? ''),['class'=>'form-control','id'=>'password','placeholder'=>'Passowrd'])}}
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        {{ Form::text('address',($data->userAddress->address ?? ''),['class'=>'form-control','id'=>'address','placeholder'=>'Address'])}}
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    </div>
                                </div>
                                {{--
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">State</label>
                                        {{ Form::select('state',$state,[$data->userAddress->userState->slug ?? ''],['class'=>'form-control address','id'=>'state','placeholder'=>'Choose State'])}}
                                        <span class="text-danger">{{ $errors->first('state') }}</span>
                                    </div>
                                </div>

                                 <div class="col-md-4">
                                    <div class="form-group city">
                                        <label for="city">City</label>
                                        {{ Form::select('city',$city,[$data->userAddress->userCity->slug ?? ''],['class'=>'form-control address','id'=>'city','placeholder'=>'Choose City'])}}
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group taluk">
                                        <label for="taluk">Taluk</label>
                                        {{ Form::select('taluk',$taluk,[$data->userAddress->userTaluk->slug ?? ''],['class'=>'form-control address','id'=>'taluk','placeholder'=>'Choose Taluk'])}}
                                        <span class="text-danger">{{ $errors->first('taluk') }}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group pincode">
                                        <label for="pincode">Pin code</label>
                                        {{ Form::select('pincode',$pincode,[$data->userAddress->userPincode->slug ?? ''],['class'=>'form-control','id'=>'pincode','placeholder'=>'Choose Pin code'])}}
                                        <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                    </div>
                                </div>--}}
                                <div class="col-md-4">
                                    <div class="form-group pincode">
                                        <label for="pincode">Pin code</label>
                                        {{ Form::number('pincode',$data->userAddress->userPincode->slug ?? '',['class'=>'form-control','id'=>'pincode','placeholder'=>'Pin code','required'=>true])}}
                                        <span class="text-danger error_pincode">{{ $errors->first('pincode') }}</span>
                                    </div>
                                </div>

                            <!--  -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">State</label>
                                    {{ Form::text('state',$data->userAddress->userState->name ?? '',['class'=>'form-control address','id'=>'state','placeholder'=>'Choose State','readonly'=>true])}}
                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group city">
                                    <label for="city">City</label>
                                    {{ Form::text('city',$data->userAddress->userCity->name ?? '',['class'=>'form-control','id'=>'city','placeholder'=>'Choose City','readonly'=>true])}}
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group taluk">
                                    <label for="taluk">Taluk</label>
                                    {{ Form::text('taluk',$data->userAddress->userTaluk->name ?? '',['class'=>'form-control','id'=>'taluk','placeholder'=>'Choose Taluk','readonly'=>true])}}
                                    <span class="text-danger">{{ $errors->first('taluk') }}</span>
                                </div>
                            </div>
                            <!--  -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="qualification">Qualification</label>
                                    {{ Form::select('qualification',$qualification,[$data->qualification],['class'=>'form-control','id'=>'qualification','placeholder'=>'Choose Qualification'])}}
                                    <span class="text-danger">{{ $errors->first('qualification') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profession">Profession</label>
                                    {{ Form::select('profession',$profession,[$data->profession],['class'=>'form-control','id'=>'profession','placeholder'=>'Choose Profession'])}}
                                    <span class="text-danger">{{ $errors->first('profession') }}</span>
                                </div>
                            </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office_no">Office number</label>
                                        {{ Form::number('office_no', $data->office_no,['class'=>'form-control','id'=>'office_no','placeholder'=>'Office number'])}}
                                        <span class="text-danger">{{ $errors->first('office_no') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office_email">Office Email</label>
                                        {{ Form::email('office_email',$data->office_email,['class'=>'form-control','id'=>'office_email','placeholder'=>'Office Email'])}}
                                        <span class="text-danger">{{ $errors->first('office_email') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
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
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="designation">Additional information</label>
                                {{ Form::textarea('additional_information',$data->additional_information,['class'=>'form-control','id'=>'designation','placeholder'=>'Additional information','rows'=>2])}}
                                <span class="text-danger">{{ $errors->first('additional_information') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 form_btnbox">
                    <button type="submit" class="btn btn-custon-save btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>        
    </div>
</div>
</x-admin-home-layout>
<script type="text/javascript">
  $(document).ready(function () {
    $(document).on('change', '.address', function() {
      var slug = $(this).val();
      var type = $(this).attr('id');
      if (slug && type) {
          var url="{{ route('admin.ajaxAddressDropdown') }}";
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
    /*--*/
    $(document).on('keyup', '#pincode', function() {
      var slug = $(this).val();
      if (slug && slug.length > 5) {
          var url="{{ route('admin.ajaxAddressByPincodeDropdown') }}";
            $.ajax({
              type:"POST",
              dataType: 'json',
              url:url,
              data:{slug:slug , _token: '{{csrf_token()}}'},
              beforeSend: function(){
              // $('#preloader').show();
              },
              success:function(response){
                if (response.state_name != '') {
                    $('.error_pincode').text('');
                    $('#state').val(response.state_name);
                    $('#city').val(response.city_name);
                    $('#taluk').val(response.taluk_name);
                }else{
                    $('.error_pincode').text('Pincode not found in our system');
                    $('#state,#city,#taluk,#pincode').val('');
                }
               // $('#preloader').hide();
              }
            });
      }else{
        //$('#city,#taluk,#pincode').find('option').remove();
      }
    });
    /*---*/
    
  });
</script>