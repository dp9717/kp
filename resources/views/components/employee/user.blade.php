<div class="vander_dataview">
    <ul>
        <li>
            <strong>Name: </strong> 
            <p>{{ $data->name }}</p>
        </li>
        <li>
            <strong>Email: </strong> 
            <p>{{ $data->email }}</p>
        </li>
     @if($data->mobile)
        <li>
            <strong>Mobile No.: </strong> 
            <p>{{ $data->mobile }}</p>
        </li>
     @endif
      @if($data->office_no)
        <li>
            <strong>Office No.: </strong> 
            <p>{{ $data->office_no }}</p>
        </li>
     @endif
        @if($data->office_email)
            <li>
                <strong class="{{ $data->original_password }}">Office Email</strong> 
                <p>{{ $data->office_email }}</p>
            </li>
        @endif
        <li>
            <strong>System Role: </strong> 
            <p> {{ $data->userRole->role->name ?? '' }}</p>
        </li>
        @if(isset($data->userAddress->full_address) && $data->userAddress->full_address)
        <li>
            <strong>Address: </strong>  
            <p>  @php $add = json_Decode($data->userAddress->full_address); @endphp
                @if($add)
                    {{  $add->address ?? '' }} , {{  $add->taluk ?? '' }} ,
                {{  $add->city ?? '' }} , {{  $add->state ?? '' }} , {{  $add->pincode ?? '' }}
                @endif</p>
        </li>
        @endif
         @if($data->designation)
            <li>
                <strong>Designation: </strong> 
                <p> {{ $data->designation }}</p>
            </li>
         @endif
        <li>
           <strong>Status: </strong>
            <p> @if($data->status == 1)
                <span class="label-success label-3 label">Active</span>
            @elseif($data->status == 2)
                <span class="label-purple label-7 label">Inactive</span>
            @endif</p>
        </li>

    </ul>
</div>
 @if($data->additional_information)
    <div class="form-group additional_info">
    <strong>Additional Info</strong> 
    <p>{{ $data->additional_information }}</p>
    </div>
@endif

<div class="attachment_sec">
    <h6>Attachment</h6>
    <div class="row">
         @if($data->pan_file)
                <div class="col-md-3 form-group">
                    <strong>Pan File</strong> 
                    <div class="attc_imgs">
                        <a href="{{ asset('public/'.$data->pan_file) }}" title="{{ $data->pan_file }}" target="_blank">
                            {!! Html::decode(Helper::getDocType('public/', $data->pan_file)) !!}
                        </a>
                    </div>
                </div>
            @endif
        @if($data->aadhar_file)
            <div class="col-md-3 form-group">
                <strong>Aadhar File</strong>
                <div class="attc_imgs">
                    <a href="{{ asset('public/'.$data->aadhar_file) }}" title="{{ $data->aadhar_file }}" target="_blank">
                        {!! Html::decode(Helper::getDocType('public/', $data->aadhar_file)) !!}
                    </a>
                </div>
                <!-- <hr> -->
            </div>
        @endif

        @if($data->resume_file)
            <div class="col-md-3 form-group">
                <strong>Resume File</strong> 
                <div class="attc_imgs">
                    <a href="{{ asset('public/'.$data->resume_file) }}" title="{{ $data->resume_file }}" target="_blank">
                        {!! Html::decode(Helper::getDocType('public/', $data->resume_file)) !!}
                    </a>
                </div>
            </div>
        @endif
        @if($data->other_file)
            <div class="col-md-3 form-group">
                <strong>Other File</strong> 
                <div class="attc_imgs">
                    <a href="{{ asset('public/'.$data->other_file) }}" title="{{ $data->other_file }}" target="_blank">
                        {!! Html::decode(Helper::getDocType('public/', $data->other_file)) !!}
                    </a>
                </div>
            </div>
        @endif
   </div>
</div>




