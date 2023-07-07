<x-admin-home-layout>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading">
                                   <h1>Edit Certificate</h1>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><a href="{{ route('admin.certificates') }}">Certificate</a> <span class="bread-slash">/</span>
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
                    <form method="post" action="{{ route('admin.updateCertificate',$data->slug) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>General Certificate</h1></div> 


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Batch</label>
                                        {{ Form::select('batch',$batch,[\App\Models\Batch::slug($data->batch_id)],['class'=>'form-control','id'=>'batch','placeholder'=>'Choose Batch','required'=>true, 'disabled' => 'disabled'])}}
                                        {{ Form::hidden('batch', \App\Models\Batch::slug($data->batch_id), []) }}
                                        <span class="text-danger">{{ $errors->first('batch') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="certificate_heading">Certificate Heading</label>
                                        {{ Form::select('certificate_heading', \App\Models\Certificate::certificateHeadings(), [$data->certi_heading], ['class'=>'form-control', 'id'=>'certificate_heading', 'placeholder'=>'Choose Certificate Heading', 'required'=>true])}}
                                        <span class="text-danger">{{ $errors->first('certificate_heading') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="logo1">Logo1 File</label>
                                        {{ Form::file('logo1_file',['class'=>'form-control','id'=>'logo1','placeholder'=>'Upload Logo1'])}}
                                        <span class="text-danger">{{ $errors->first('logo1_file') }}</span>
                                    </div>
                                    @if($data->logo1_file)
                                       <a href="{{ asset('public/'.$data->logo1_file) }}" title="{{ $data->logo1_file }}" target="_blank">
                                            {!! Html::decode(Helper::getDocType('public/', $data->logo1_file)) !!}
                                        </a>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="logo2">Logo2 File</label>
                                        {{ Form::file('logo2_file',['class'=>'form-control','id'=>'logo2','placeholder'=>'Upload Logo2'])}}
                                        <span class="text-danger">{{ $errors->first('logo2_file') }}</span>
                                    </div>
                                    @if($data->logo2_file)
                                       <a href="{{ asset('public/'.$data->logo2_file) }}" title="{{ $data->logo2_file }}" target="_blank">
                                            {!! Html::decode(Helper::getDocType('public/', $data->logo2_file)) !!}
                                        </a>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="logo3_file">Logo3 File</label>
                                        {{ Form::file('logo3_file',['class'=>'form-control','id'=>'logo3_file','placeholder'=>'Upload Logo3 File'])}}
                                        <span class="text-danger">{{ $errors->first('logo3_file') }}</span>
                                    </div>
                                    @if($data->logo3_file)
                                       <a href="{{ asset('public/'.$data->logo3_file) }}" title="{{ $data->logo3_file }}" target="_blank">
                                            {!! Html::decode(Helper::getDocType('public/', $data->logo3_file)) !!}
                                        </a>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="issued_on">Issued On</label>
                                        <div class="data-custon-pick" id="issuedDate">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="issued_on" class="form-control" id="" placeholder="Issued On" value="{{ old('issued_on') ?? Helper::date($data->issued_on, 'd-m-Y') }}" required>
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('issued_on') }}</span>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="certificate_validity">Certificate Validity</label>
                                        {{ Form::select('certificate_validity', \App\Models\Certificate::certificateValidities(), $data->certificate_type, ['class'=>'form-control', 'id'=>'certificate_validity', 'placeholder'=>'Choose Certificate Validity', 'required'=>true])}}
                                        <span class="text-danger">{{ $errors->first('certificate_validity') }}</span>
                                    </div>
                                </div>

                                @php
                                    if($data->certificate_type == 1 && $data->validity_date) {
                                        $cssv = 'display:block';
                                    } else {
                                        $cssv = 'display:none';
                                    }
                                    
                                @endphp
                                <div class="col-md-4" id="validity_sec" style="{{ $cssv }}">
                                    <div class="form-group">
                                        <label for="validity_date">Validity Date</label>
                                        <div class="data-custon-pick" id="validityDate">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="validity_date" class="form-control validity_date" id="validity_date" placeholder="Validity Date" value="{{ old('validity_date') ?? Helper::date($data->validity_date, 'd-m-Y') }}">
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('validity_date') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <!--  --> 
                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Signatures</h1></div>
                                <div class="col-md-12  vander_dataview">
                                    <table class="table">
                                        <tr>
                                          <th>Sr.</th>
                                          <th>Name</th>
                                          <th>Designation</th>
                                          <th>Company</th>
                                          <th>Signature</th>
                                        </tr>
                                        <tr>
                                            <td>Signature1</td>
                                            <td>
                                                <div class="form-group">
                                                    {{ Form::text('name[0]', $data->name1, ['class'=>'form-control', 'placeholder'=>'Name'])}}
                                                    <span class="text-danger">{{ $errors->first('name.0') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    {{ Form::text('designation[0]', $data->designation1, ['class'=>'form-control', 'placeholder'=>'Designation'])}}
                                                    <span class="text-danger">{{ $errors->first('designation.0') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group"> 
                                                    {{ Form::text('company[0]', $data->company1, ['class'=>'form-control', 'placeholder'=>'Company'])}}
                                                    <span class="text-danger">{{ $errors->first('company.0') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group"> 
                                                    {{ Form::file('signature[0]', ['class'=>'form-control',  'placeholder'=>'Upload Signature File'])}}
                                                    <span class="text-danger">{{ $errors->first('signature.0') }}</span>
                                                </div>
                                                @if($data->signature1)
                                                   <a href="{{ asset('public/'.$data->signature1) }}" title="{{ $data->signature1 }}" target="_blank">
                                                        {!! Html::decode(Helper::getDocType('public/', $data->signature1)) !!}
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Signature2</td>
                                            <td>
                                                <div class="form-group">
                                                    {{ Form::text('name[1]', $data->name2, ['class'=>'form-control', 'placeholder'=>'Name'])}}
                                                    <span class="text-danger">{{ $errors->first('name.1') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    {{ Form::text('designation[1]', $data->designation2, ['class'=>'form-control', 'placeholder'=>'Designation'])}}
                                                    <span class="text-danger">{{ $errors->first('designation.1') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group"> 
                                                    {{ Form::text('company[1]', $data->company2, ['class'=>'form-control', 'placeholder'=>'Company'])}}
                                                    <span class="text-danger">{{ $errors->first('company.1') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group"> 
                                                    {{ Form::file('signature[1]', ['class'=>'form-control',  'placeholder'=>'Upload Signature File'])}}
                                                    <span class="text-danger">{{ $errors->first('signature.1') }}</span>
                                                </div>
                                                @if($data->signature2)
                                                   <a href="{{ asset('public/'.$data->signature2) }}" title="{{ $data->signature2 }}" target="_blank">
                                                        {!! Html::decode(Helper::getDocType('public/', $data->signature2)) !!}
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Signature3</td>
                                            <td>
                                                <div class="form-group">
                                                    {{ Form::text('name[2]', $data->name3, ['class'=>'form-control', 'placeholder'=>'Name'])}}
                                                    <span class="text-danger">{{ $errors->first('name.2') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    {{ Form::text('designation[2]', $data->designation3, ['class'=>'form-control', 'placeholder'=>'Designation'])}}
                                                    <span class="text-danger">{{ $errors->first('designation.2') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group"> 
                                                    {{ Form::text('company[2]', $data->company3, ['class'=>'form-control', 'placeholder'=>'Company'])}}
                                                    <span class="text-danger">{{ $errors->first('company.2') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group"> 
                                                    {{ Form::file('signature[2]', ['class'=>'form-control',  'placeholder'=>'Upload Signature File'])}}
                                                    <span class="text-danger">{{ $errors->first('signature.2') }}</span>
                                                </div>
                                                @if($data->signature3)
                                                   <a href="{{ asset('public/'.$data->signature3) }}" title="{{ $data->signature3 }}" target="_blank">
                                                        {!! Html::decode(Helper::getDocType('public/', $data->signature3)) !!}
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--  --> 
                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Logistics</h1></div>   
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label for="signature">Do you need a hard copy to be Printed</label>
                                        <div class="row">
                                            @forelse(\App\Models\Certificate::hardCopy() as $key => $val)
                                               <div class="col-md-2">
                                                    <div class="i-checks pull-left">
                                                        <label>
                                                            <input type="radio" value="{{$key}}" class="hard_copy" name="hard_copy" @if($data->hard_copy == $key) checked @endif > <i></i> {{$val}}
                                                        </label>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <span class="text-danger">{{ $errors->first('hard_copy') }}</span>
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="needed_by">Needed by</label>
                                        <div class="data-custon-pick" id="neededDate">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="needed_by" class="form-control" id="" placeholder="Needed by" value="{{ old('needed_by') ?? Helper::date($data->needed_by, 'd-m-Y') }}" required>
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('needed_by') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vendor">Printing Vendor</label>
                                        {{ Form::select('vendor',$vendors,[json_decode($data->vendor_ary)->slug],['class'=>'form-control','id'=>'vendor','placeholder'=>'Choose Printing Vendor','required'=>true])}}
                                        <span class="text-danger">{{ $errors->first('vendor') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <!--  --> 
                        @php
                            if(old('vendor') || $data->vendor_id) {
                                $css = 'display:block';
                            } else {
                                $css = 'display:none';
                            }
                        @endphp
                        <div class="form_section vendorDetail" style="{{ $css }}">
                            @php 
                                if(old('vendor')){
                                    $v_data = \App\Models\Vendor::where('slug',old('vendor'))->first();
                                }else{
                                    $v_data = \App\Models\Vendor::where('id',$data->vendor_id)->first();
                                }
                            @endphp
                            @if($v_data)
                                <div class="col-md-12"> <h1>Vendor Detail ( {{ $v_data->slug }} )</h1></div> 
                                <div class="row">
                                    <div class="col-md-12 vander_dataview">
                                        <ul>
                                            <li>
                                                <strong>Address: </strong>
                                                <p>  {{ json_decode($v_data->full_address)->address ?? '' }}</p>
                                            </li>
                                            <li>
                                                <strong>Taluk: </strong>
                                                <p>  {{ json_decode($v_data->full_address)->taluk ?? '' }}</p>
                                            </li>
                                     
                                            <li>
                                                <strong>City: </strong>
                                                <p>  {{ json_decode($v_data->full_address)->city ?? '' }}</p>
                                            </li>
                                            <li>
                                                <strong>State: </strong>
                                                <p>  {{ json_decode($v_data->full_address)->state ?? '' }}</p>
                                            </li>

                                            <li>
                                                <strong>PinCode: </strong>
                                                <p>  {{ json_decode($v_data->full_address)->pincode ?? '' }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12"><h1>Point Of Contact (POC)</h1></div>
                                <div class="row"> 
                                    @if($v_data->poc) 
                                        <div class="col-md-12  vander_dataview">
                                            <table class="table">
                                                <tr>
                                                  <th>Sr.</th>
                                                  <th>Name</th>
                                                  <th>Email</th>
                                                  <th>Contact</th>
                                                </tr>
                                                @php
                                                    $pocs = json_decode($v_data->poc);
                                                @endphp
                                                @forelse($pocs as $key => $val)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $val->poc_name }}</td>
                                                        <td>{{ $val->poc_email }}</td>
                                                        <td>{{ $val->poc_contact }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4">Poc not found</td>
                                                    </tr>
                                                @endforelse
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div> 
                        <!--  --> 
                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Additional information</h1></div>   
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::textarea('additional_information',$data->additional_information,['class'=>'form-control','id'=>'additional_information','placeholder'=>'Additional information'])}}
                                        <span class="text-danger">{{ $errors->first('additional_information') }}</span>
                                    </div>
                                </div> 
                            </div>
                        </div> 

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

    let dt = new Date();
    dt.setDate(dt.getDate() + 8);

    $('#neededDate .input-group.date').datepicker({
        startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true,
        format: 'd-m-yyyy',
        startDate: dt
    });
    $('#issuedDate .input-group.date, #validityDate .input-group.date').datepicker({
        startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true,
        format: 'd-m-yyyy',
        startDate: new Date()
    });
    $(document).ready(function () {
        $(document).on('change', '#certificate_validity', function() {
            var valid = $(this).val();
            if(valid == 1){
                $("#validity_sec").css('display', 'block');
                $("#validity_date").attr('required', true);
            } else {
                $("#validity_sec").css('display', 'none');
                $("#validity_date").attr('required', false);
            }
        });
        $(document).on('change', '#vendor', function() {
            var slug = $(this).val();
            if (slug) {
                var url="{{ route('admin.ajaxAdminView') }}";
                $.ajax({
                    type:"POST",
                    url:url,
                    data:{slug:slug , _token: '{{csrf_token()}}',type:'certificateVendorView'},
                    beforeSend: function(){
                        // $('#preloader').show();
                    },
                    success:function(response){
                        if (response) {
                            $('.vendorDetail').empty().html(response).show();
                            // $('#PrimaryModalhdbgcl .modal-body').html(response);
                            // $('#PrimaryModalhdbgcl').modal('show');
                        }
                        // $('#preloader').hide();
                    }
                });
            } else {
                $('.vendorDetail').hide();
            }
        });
    });

</script>