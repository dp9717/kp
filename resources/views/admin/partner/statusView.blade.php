<x-admin-home-layout>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                               <h1>Partner Status</h1>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                </li>
                                <li><a href="{{ route('admin.partners') }}">Partner</a> <span class="bread-slash">/</span>
                                </li>
                                <li><span class="bread-blod">Approval</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                   
                    <!--  -->
                </div>
            </div>
            <!-- pro -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form_section popupdata">
                    <div class="row">
                        <div class="col-md-12"> <h1>Partner Information</h1></div>  
                        <x-employee.partner :$data/>
                    </div>
                </div>

                <form method="post" action="{{ route('admin.partnerStatusApprove',$data->slug) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf
                    <div class="form_section">
                        <div class="row">
                                <div class="col-md-12"> <h1>Status Approval</h1></div>
                                <div class="col-md-6">
                                    {{ Form::label('user','User') }}
                                    {{ Form::select('user',$users,[],['class'=>'form-control custom-select select2','placeholder'=>'User','id'=>'user', 'required'=>true]) }}
                                    <span class="text-danger">{{ $errors->first('user')}}</span>
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        {{ Form::select('status',$status,[  ],['class'=>'form-control','id'=>'status','placeholder'=>'Approval status','required'=>true])}}
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                        {{ Form::text('comment',($data->comment ?? ''),['class'=>'form-control','id'=>'comment','placeholder'=>'Comment'])}}
                                        <span class="text-danger">{{ $errors->first('comment') }}</span>
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
  });
</script>