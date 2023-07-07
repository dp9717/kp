<x-admin-home-layout>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading">
                                   <h1>Edit Partner</h1>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><a href="{{ route('admin.partners') }}">Partner</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><span class="bread-blod">Edit</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                </div>
                <!-- pro -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form method="post" action="{{ route('admin.updatePartner',$data->slug) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Partner Information</h1></div>
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Name</label>
                                        {{ Form::text('name',$data->name,['class'=>'form-control','id'=>'username','placeholder'=>'Name'])}}
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gst">GST</label>
                                        {{ Form::text('gst', $data->gst,['class'=>'form-control','id'=>'','placeholder'=>'GST'])}}
                                        <span class="text-danger">{{ $errors->first('gst') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pan">PAN</label>
                                        {{ Form::text('pan',$data->pan,['class'=>'form-control','id'=>'pan','placeholder'=>'PAN'])}}
                                        <span class="text-danger">{{ $errors->first('pan') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cin">CIN</label>
                                        {{ Form::text('cin',$data->cin,['class'=>'form-control','id'=>'cin','placeholder'=>'CIN'])}}
                                        <span class="text-danger">{{ $errors->first('cin') }}</span>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        {{ Form::text('address',($data->address ?? ''),['class'=>'form-control','id'=>'address','placeholder'=>'Address'])}}
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    </div>
                                </div>
                                {{--
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">State</label>
                                        {{ Form::select('state',$state,[\App\Models\State::slug($data->state_id) ?? ''],['class'=>'form-control address','id'=>'state','placeholder'=>'Choose State'])}}
                                        <span class="text-danger">{{ $errors->first('state') }}</span>
                                    </div>
                                </div>

                                 <div class="col-md-4">
                                    <div class="form-group city">
                                        <label for="city">City</label>
                                        {{ Form::select('city',$city,[\App\Models\City::slug($data->city_id) ?? ''],['class'=>'form-control address','id'=>'city','placeholder'=>'Choose City'])}}
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group taluk">
                                        <label for="taluk">Taluk</label>
                                        {{ Form::select('taluk',$taluk,[\App\Models\Taluk::slug($data->taluk_id) ?? ''],['class'=>'form-control address','id'=>'taluk','placeholder'=>'Choose Taluk'])}}
                                        <span class="text-danger">{{ $errors->first('taluk') }}</span>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group pincode">
                                        <label for="pincode">Pin code</label>
                                        {{ Form::select('pincode',$pincode,[\App\Models\Pincode::slug($data->pincode_id) ?? ''],['class'=>'form-control','id'=>'pincode','placeholder'=>'Choose Pin code'])}}
                                        <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                    </div>
                                </div>--}}

                                <div class="col-md-4">
                                    <div class="form-group pincode">
                                        <label for="pincode">Pin code</label>
                                        {{ Form::number('pincode',\App\Models\Pincode::slug($data->pincode_id) ?? '',['class'=>'form-control','id'=>'pincode','placeholder'=>'Pin code','required'=>true])}}
                                        <span class="text-danger error_pincode">{{ $errors->first('pincode') }}</span>
                                    </div>
                                </div>

                            <!--  -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">State</label>
                                    {{ Form::text('state',\App\Models\State::name($data->state_id) ?? '',['class'=>'form-control address','id'=>'state','placeholder'=>'Choose State','readonly'=>true])}}
                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group city">
                                    <label for="city">City</label>
                                    {{ Form::text('city',\App\Models\City::name($data->city_id) ?? '',['class'=>'form-control','id'=>'city','placeholder'=>'Choose City','readonly'=>true])}}
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group taluk">
                                    <label for="taluk">Taluk</label>
                                    {{ Form::text('taluk',\App\Models\Taluk::name($data->taluk_id) ?? '',['class'=>'form-control','id'=>'taluk','placeholder'=>'Choose Taluk','readonly'=>true])}}
                                    <span class="text-danger">{{ $errors->first('taluk') }}</span>
                                </div>
                            </div>
                            <!--  -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            @forelse($data->file as $fkey => $val)
                                                <div class="col-md-2 mb-2">
                                                    <div class="attc_imgs savedimg_box">
                                                            {!! Html::decode(Helper::getDocType('public/', $val->file_path)) !!}
                                                            <a href="{{route('admin.fileRemovePartner',[$val->id,$data->slug])}}" title="{{ $val->file_path }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                     </div>
                                </div>

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
                                            {{ Form::textarea('additional_information',$data->additional_information,['class'=>'form-control','id'=>'designation','placeholder'=>'Additional information'])}}
                                            <span class="text-danger">{{ $errors->first('additional_information') }}</span>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <!--  --> 
                      
                        <!--  -->
                        <!-- poc --> 
                        <div class="form_section">
                            <div class="col-md-12"> <h1>POC</h1></div> 
                            <div class="row">
                               <div class="col-md-4">
                                 <div class="form-group">
                                      {{ Form::label('Name','Name') }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                 <div class="form-group">
                                      {{ Form::label('Email','Email') }}
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                 <div class="form-group">
                                      {{ Form::label('Contact','Contact') }}
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-12">
                                @if($data->poc)
                                    @php $item=json_decode($data->poc); @endphp
                                    @forelse($item as $itemKey => $itemVal)
                                      <div class="row w-100" id="s{{$itemKey}}">
                                         <div class="col-md-4">
                                           <div class="form-group">
                                               {{ Form::text('poc_name[]',$itemVal->poc_name ?? '',['class'=>'form-control','placeholder'=>'Name','required'=>true]) }}
                                                <span class="text-danger">{{ $errors->first('poc_name.*')}}</span>
                                              </div>
                                          </div>
                                          <div class="col-md-4">
                                           <div class="form-group">
                                               {{ Form::email('poc_email[]',$itemVal->poc_email ?? '',['class'=>'form-control','placeholder'=>'Email','required'=>true]) }}
                                                <span class="text-danger">{{ $errors->first('poc_email.*')}}</span>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                           <div class="form-group">
                                                {{ Form::text('poc_contact[]',$itemVal->poc_contact ?? '',['class'=>'form-control','placeholder'=>'Contact','required'=>true]) }}
                                                <span class="text-danger">{{ $errors->first('poc_contact.*')}}</span>
                                              </div>
                                          </div>
                                          
                                        <div class="col-md-1 ItemRemove">
                                         <div class="form-group">
                                            {!! Html::decode(Form::button('<i class="fa fa-trash"></i>',['class'=>'btn btn-danger','onclick'=>"$('#s".$itemKey."').remove()"])) !!}
                                         </div>
                                        </div>
                                      </div>
                                    @empty

                                    @endforelse
                                    
                                @else
                                    <div class="row">
                                       <div class="col-md-4">
                                         <div class="form-group">
                                               {{ Form::text('poc_name[]','',['class'=>'form-control','placeholder'=>'Name','required'=>true]) }}
                                              <span class="text-danger">{{ $errors->first('poc_name.*')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                         <div class="form-group">
                                              {{ Form::email('poc_email[]','',['class'=>'form-control','placeholder'=>'Email','required'=>true]) }}
                                              <span class="text-danger">{{ $errors->first('poc_email.*')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                         <div class="form-group">
                                              {{ Form::text('poc_contact[]','',['class'=>'form-control','placeholder'=>'Contact','required'=>true]) }}
                                              <span class="text-danger">{{ $errors->first('poc_contact.*')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div id="Goods">
                                </div>
                                <div class="col-md-12 text-right">
                                    {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                                </div>
                            </div>
                        </div> 
                          
                        <!-- dire -->
                        <!-- poc --> 
                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Director</h1></div> 
                            
                               <div class="col-md-4">
                                 <div class="form-group">
                                      {{ Form::label('Name','Name') }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                 <div class="form-group">
                                      {{ Form::label('Email','Email') }}
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                 <div class="form-group">
                                      {{ Form::label('Contact','Contact') }}
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-12">
                                @if($data->director)
                                    @php $item=json_decode($data->director); @endphp
                                    @forelse($item as $itemKey => $itemVal)
                                      <div class="row w-100" id="sD{{$itemKey}}">
                                         <div class="col-md-4">
                                           <div class="form-group">
                                               {{ Form::text('director_name[]',$itemVal->director_name ?? '',['class'=>'form-control','placeholder'=>'Name','required'=>true]) }}
                                                <span class="text-danger">{{ $errors->first('director_name.*')}}</span>
                                              </div>
                                          </div>
                                          <div class="col-md-4">
                                           <div class="form-group">
                                               {{ Form::email('director_email[]',$itemVal->director_email ?? '',['class'=>'form-control','placeholder'=>'Email','required'=>true]) }}
                                                <span class="text-danger">{{ $errors->first('director_email.*')}}</span>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                           <div class="form-group">
                                                {{ Form::text('director_contact[]',$itemVal->director_contact ?? '',['class'=>'form-control','placeholder'=>'Contact','required'=>true]) }}
                                                <span class="text-danger">{{ $errors->first('director_contact.*')}}</span>
                                              </div>
                                          </div>
                                          
                                        <div class="col-md-1 ItemRemoveD">
                                         <div class="form-group">
                                            {!! Html::decode(Form::button('<i class="fa fa-trash"></i>',['class'=>'btn btn-danger','onclick'=>"$('#sD".$itemKey."').remove()"])) !!}
                                         </div>
                                        </div>
                                      </div>
                                    @empty

                                    @endforelse
                                    
                                @else
                                    <div class="row">
                                       <div class="col-md-4">
                                         <div class="form-group">
                                               {{ Form::text('director_name[]','',['class'=>'form-control','placeholder'=>'Name','required'=>true]) }}
                                              <span class="text-danger">{{ $errors->first('director_name.*')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                         <div class="form-group">
                                              {{ Form::email('director_email[]','',['class'=>'form-control','placeholder'=>'Email','required'=>true]) }}
                                              <span class="text-danger">{{ $errors->first('director_email.*')}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                         <div class="form-group">
                                              {{ Form::text('director_contact[]','',['class'=>'form-control','placeholder'=>'Contact','required'=>true]) }}
                                              <span class="text-danger">{{ $errors->first('director_contact.*')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div id="GoodsD">
                                </div>
                                <div class="col-md-12 text-right">
                                    {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plusD'])) !!}
                                </div>
                            </div>
                        </div> 
                          
                        <!--  -->
                        <!--  -->
                        <div class="col-md-12 form_btnbox">
                            <button type="submit" class="btn btn-custon-save btn-primary">{{ __('Save') }}</button>
                        </div>    
                    </form>
                </div>
                <!-- end pro -->
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


   /*poc*/
    $('.plus').click(function(){
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"><div class="col-md-4"> <div class="form-group"><input class="form-control" placeholder="Name" required id="" name="poc_name[]" type="text"></div></div><div class="col-md-4"> <div class="form-group"> <input class="form-control" placeholder="Email" required id="" name="poc_email[]" type="email"></div></div><div class="col-md-3"> <div class="form-group"><input class="form-control" placeholder="Contact" required id="" name="poc_contact[]" type="text"> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash"></i></button></div></div></div>';
    $('#Goods').append(clone);
    var cls = $('.Goods').length;
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
    if (cls) {
      $('.trash').show();
    }
  });
  function removeItemRow(argument) {
   // alert();
    $('#removeItemRow'+argument).remove();
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
}
/*dirc*/

$('.plusD').click(function(){
    var cls = $('.GoodsD').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row newGD GoodsD" id="removeItemRowD'+cls+'"><div class="col-md-4"> <div class="form-group"><input class="form-control" placeholder="Name" required id="" name="director_name[]" type="text" required></div></div><div class="col-md-4"> <div class="form-group"> <input class="form-control" placeholder="Email" required id="" name="director_email[]" type="email" required></div></div><div class="col-md-3"> <div class="form-group"><input class="form-control" placeholder="Contact" required id="" name="director_contact[]" type="text" required> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRowD('+cls+')"><i class="fa fa-trash"></i></button></div></div></div>';
    $('#GoodsD').append(clone);
    var cls = $('.GoodsD').length;
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
    if (cls) {
      $('.trash').show();
    }
  });
  function removeItemRowD(argument) {
   // alert();
    $('#removeItemRowD'+argument).remove();
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
  }
</script>