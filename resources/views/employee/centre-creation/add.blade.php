<x-user-home-layout>
    <div class="main-content">
        <div class="container-fluid"> 
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading">
                                   <h1>Add Centre Creation</h1>
                                </div> 
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('user.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><a href="{{ route('user.centreCreations') }}">Centre Creation</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><span class="bread-blod">Add</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                       
                        <!--  -->
                    </div>
                </div>
                <!-- pro -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form method="post" action="{{ route('user.saveCentreCreation') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Centre Creation</h1></div> 


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Name</label>
                                        {{ Form::text('name','',['class'=>'form-control','id'=>'username','placeholder'=>'Name'])}}
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact">Contact</label>
                                        {{ Form::number('contact', '',['class'=>'form-control','id'=>'contact','placeholder'=>'Contact'])}}
                                        <span class="text-danger">{{ $errors->first('contact') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        {{ Form::email('email','',['class'=>'form-control','id'=>'email','placeholder'=>'Email'])}}
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="centre_head">Centre Head</label>
                                        {{ Form::select('centre_head',$role,[],['class'=>'form-control','id'=>'centre_head','placeholder'=>'Choose Centre Head'])}}
                                        <span class="text-danger">{{ $errors->first('centre_head') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        {{ Form::text('address','',['class'=>'form-control','id'=>'address','placeholder'=>'Address'])}}
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    </div>
                                </div>
                                {{--
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">State</label>
                                        {{ Form::select('state',$state,[],['class'=>'form-control address','id'=>'state','placeholder'=>'Choose State'])}}
                                        <span class="text-danger">{{ $errors->first('state') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group city">
                                        <label for="city">City</label>
                                        {{ Form::select('city',$city,[],['class'=>'form-control','id'=>'city','placeholder'=>'Choose City'])}}
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group taluk">
                                        <label for="taluk">Taluk</label>
                                        {{ Form::select('taluk',$taluk,[],['class'=>'form-control','id'=>'taluk','placeholder'=>'Choose Taluk'])}}
                                        <span class="text-danger">{{ $errors->first('taluk') }}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group pincode">
                                        <label for="pincode">Pin code</label>
                                        {{ Form::select('pincode',$pincode,[],['class'=>'form-control','id'=>'pincode','placeholder'=>'Choose Pin code'])}}
                                        <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                    </div>
                                </div>
                                --}}
                                <div class="col-md-4">
                                <div class="form-group pincode">
                                    <label for="pincode">Pin code</label>
                                    {{ Form::number('pincode','',['class'=>'form-control','id'=>'pincode','placeholder'=>'Pin code','required'=>true])}}
                                    <span class="text-danger error_pincode">{{ $errors->first('pincode') }}</span>
                                </div>
                            </div>

                            <!--  -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">State</label>
                                    {{ Form::text('state','',['class'=>'form-control address','id'=>'state','placeholder'=>'Choose State','readonly'=>true])}}
                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group city">
                                    <label for="city">City</label>
                                    {{ Form::text('city','',['class'=>'form-control','id'=>'city','placeholder'=>'Choose City','readonly'=>true])}}
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group taluk">
                                    <label for="taluk">Taluk</label>
                                    {{ Form::text('taluk','',['class'=>'form-control','id'=>'taluk','placeholder'=>'Choose Taluk','readonly'=>true])}}
                                    <span class="text-danger">{{ $errors->first('taluk') }}</span>
                                </div>
                            </div>
                            <!--  -->
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="upload_file">Upload File</label>
                                        {{ Form::file('upload_file[]',['class'=>'form-control','id'=>'upload_file','placeholder'=>'Upload File','multiple'=>true])}}
                                        <span class="text-danger">{{ $errors->first('upload_file.*') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Additional information</h1></div>   
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::textarea('additional_information','',['class'=>'form-control','id'=>'designation','placeholder'=>'Additional information'])}}
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
                <!-- end pro -->
               
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