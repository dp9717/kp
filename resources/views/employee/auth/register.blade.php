<style>
    .login-box, .register-box {
    max-width: 800px !important;
    width: 100%;
}
.login-page, .register-page {
    height: auto !important;
}

.form-control {
    padding: 6px 12px 6px 15px !important;
    height: 45px !important;
    border-radius: 100px !important;
}
textarea.form-control {
    height: auto !important;
    border-radius: 15px !important;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

.form-control {
    border-radius: 0 !important;
}

textarea.form-control {
    border-radius: 0 !important;
}

.col-md-12.lr_footer {
    text-align: center;
}

.Contact_admin h4 {
    text-align: left;
    margin-top: 10px;
}

.formsection .form-control {
    background-color: #fff !important;
    border: 1px solid #E4E4EB !important;
    padding: 10px 15px;
    font-size: 14px;
    border-radius: 50px !important;
}

.formsection label {
    font-weight: 400;
    color: #160A01;
}

</style>
<x-user-login-layout>
    
        <form method="POST" action="{{ route('user.store') }}" class="registerUser" enctype="multipart/form-data">
        @csrf
        <!-- user -->

        <!-- Email Address -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="role">Role</label>
                {{ Form::select('role',$role,[],['class'=>'form-control','id'=>'role','placeholder'=>'Choose Role'])}}
                <span class="text-danger">{{ $errors->first('role') }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="username">Name</label>
                {{ Form::text('name','',['class'=>'form-control','id'=>'username','placeholder'=>'Name'])}}
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="contact">Contact</label>
                {{ Form::number('contact', '',['class'=>'form-control','id'=>'contact','placeholder'=>'Contact'])}}
                <span class="text-danger">{{ $errors->first('contact') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                {{ Form::email('email','',['class'=>'form-control','id'=>'email','placeholder'=>'Email'])}}
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="address">Address</label>
                {{ Form::text('address','',['class'=>'form-control','id'=>'address','placeholder'=>'Address'])}}
                <span class="text-danger">{{ $errors->first('address') }}</span>
            </div>
        </div>
        {{--
        <div class="col-md-6">
            <div class="form-group">
                <label for="category">State</label>
                {{ Form::select('state',$state,[],['class'=>'form-control address','id'=>'state','placeholder'=>'Choose State'])}}
                <span class="text-danger">{{ $errors->first('state') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group city">
                <label for="city">City</label>
                {{ Form::select('city',$city,[],['class'=>'form-control','id'=>'city','placeholder'=>'Choose City'])}}
                <span class="text-danger">{{ $errors->first('city') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group taluk">
                <label for="taluk">Taluk</label>
                {{ Form::select('taluk',$taluk,[],['class'=>'form-control','id'=>'taluk','placeholder'=>'Choose Taluk'])}}
                <span class="text-danger">{{ $errors->first('taluk') }}</span>
            </div>
        </div>
         <div class="col-md-6">
            <div class="form-group pincode">
                <label for="pincode">Pin code</label>
                {{ Form::select('pincode',$pincode,[],['class'=>'form-control','id'=>'pincode','placeholder'=>'Choose Pin code'])}}
                <span class="text-danger">{{ $errors->first('pincode') }}</span>
            </div>
        </div>--}}
        <div class="col-md-6">
            <div class="form-group pincode">
                <label for="pincode">Pin code</label>
                {{ Form::number('pincode','',['class'=>'form-control','id'=>'pincode','placeholder'=>'Pin code','required'=>true])}}
                <span class="text-danger error_pincode">{{ $errors->first('pincode') }}</span>
            </div>
        </div>

        <!--  -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="category">State</label>
                {{ Form::text('state','',['class'=>'form-control address','id'=>'state','placeholder'=>'Choose State','readonly'=>true])}}
                <span class="text-danger">{{ $errors->first('state') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group city">
                <label for="city">City</label>
                {{ Form::text('city','',['class'=>'form-control','id'=>'city','placeholder'=>'Choose City','readonly'=>true])}}
                <span class="text-danger">{{ $errors->first('city') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group taluk">
                <label for="taluk">Taluk</label>
                {{ Form::text('taluk','',['class'=>'form-control','id'=>'taluk','placeholder'=>'Choose Taluk','readonly'=>true])}}
                <span class="text-danger">{{ $errors->first('taluk') }}</span>
            </div>
        </div>
        <!--  -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="qualification">Qualification</label>
                {{ Form::select('qualification',$qualification,[],['class'=>'form-control','id'=>'qualification','placeholder'=>'Choose Qualification'])}}
                <span class="text-danger">{{ $errors->first('qualification') }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="profession">Profession</label>
                {{ Form::select('profession',$profession,[],['class'=>'form-control','id'=>'profession','placeholder'=>'Choose Profession'])}}
                <span class="text-danger">{{ $errors->first('profession') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="office_no">Office number</label>
                {{ Form::number('office_no', '',['class'=>'form-control','id'=>'office_no','placeholder'=>'Office number'])}}
                <span class="text-danger">{{ $errors->first('office_no') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="office_email">Office Email</label>
                {{ Form::email('office_email','',['class'=>'form-control','id'=>'office_email','placeholder'=>'Office Email'])}}
                <span class="text-danger">{{ $errors->first('office_email') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="designation">Designation</label>
                {{ Form::text('designation','',['class'=>'form-control','id'=>'designation','placeholder'=>'Designation'])}}
                <span class="text-danger">{{ $errors->first('designation') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="pan_file">Pan card</label>
                {{ Form::file('pan_file',['class'=>'form-control','id'=>'pan_file','placeholder'=>'Pan card'])}}
                <span class="text-danger">{{ $errors->first('pan_file') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="aadhar_file">Aadhar card</label>
                {{ Form::file('aadhar_file',['class'=>'form-control','id'=>'aadhar_file','placeholder'=>'Aadhar card'])}}
                <span class="text-danger">{{ $errors->first('aadhar_file') }}</span>
            </div>
        </div>



        <div class="col-md-6">
            <div class="form-group">
                <label for="resume_file">Resume File</label>
                {{ Form::file('resume_file',['class'=>'form-control','id'=>'resume_file','placeholder'=>'Resume File'])}}
                <span class="text-danger">{{ $errors->first('resume_file') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="resume_file">Other File</label>
                {{ Form::file('other_file',['class'=>'form-control','id'=>'other_file','placeholder'=>'Other File'])}}
                <span class="text-danger">{{ $errors->first('other_file') }}</span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="designation">Additional information</label>
                {{ Form::textarea('additional_information','',['class'=>'form-control','id'=>'designation','placeholder'=>'Additional information','rows'=>2])}}
                <span class="text-danger">{{ $errors->first('additional_information') }}</span>
            </div>
        </div>
        
        <p class="terms_cnt">By continuing , you agree to SSRDP’s <a href="#">Privacy Policy</a>, <a href="#">Cookie Policy</a> & all other <a href="#">Terms & Conditions</a></p>



        
            <div class="col-md-12 lr_footer">
                <button type="submit" class="btn btn-primary btn-block">Sign up</button>
            </div>
            <!--<div class="col-md-12 Contact_admin">-->
            <!--    <h4>Already registered,<a href="{{route('user.login')}}">Log in</a></h4>-->
            <!--</div>-->
    </form>

   
</x-user-login-layout>

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

    /*--*/
    $(document).on('keyup', '#pincode', function() {
      var slug = $(this).val();
      if (slug && slug.length > 5) {
          var url="{{ route('user.ajaxAddressByPincodeDropdown') }}";
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