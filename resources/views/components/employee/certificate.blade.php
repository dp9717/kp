@php
	$full_address = json_decode($data->vendor_ary)->full_address;
@endphp
<div class="row">
    <div class="col-md-12 vander_dataview">
        <ul>
              
            <li>
                <strong>Batch: </strong>
                <p>  {{ $data->batch->slug ?? '' }}</p>
            </li>
            <li>
                <strong>Certificate Heading: </strong>
                <p>  {{ \App\Models\Certificate::certificateHeadings($data->certi_heading) }}</p>
            </li>
            <li>
                <strong>Issued On: </strong>
                <p>{{ Helper::date($data->issued_on, 'd-m-Y') }}</p>
            </li>
            <li>
                <strong>Certificate Validity Type: </strong>
                <p>{{ \App\Models\Certificate::certificateValidities($data->certificate_type) }}</p>
            </li>
            @if($data->certificate_type == 1)
                <li>
                    <strong>Validity Date: </strong>
                    <p>{{ Helper::date($data->validity_date, 'd-m-Y') }}</p>
                </li>
            @endif
            <li>
                <strong>Do you need a hard copy to be Printed: </strong>
                <p>  {{ \App\Models\Certificate::hardCopy($data->hard_copy) }}</p>
            </li>
     
            <li>
                <strong>Needed By: </strong>
                <p>{{ Helper::date($data->needed_by, 'd-m-Y') }}</p>
            </li>
            <li>
                <strong>Printing Vendor: </strong>
                <p>  {{ json_decode($data->vendor_ary)->name ?? '' }}</p>
            </li>

            <li>
                <strong>Address: </strong>
                <p>  {{ json_decode($full_address)->address ?? '' }}</p>
            </li>

            <li>
                <strong>Taluk: </strong> 
                <p>{{ json_decode($full_address)->taluk ?? '' }} </p>
            </li>
            <li>
                <strong>City: </strong> 
                <p>{{ json_decode($full_address)->city ?? '' }}</p>
            </li>

            <li>
                <strong>State: </strong> 
                <p>{{ json_decode($full_address)->state ?? '' }}</p>
            </li>
            <li>
                <strong>PinCode: </strong> 
                <p>{{ json_decode($full_address)->pincode ?? '' }}</p>
            </li>

        </ul>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
		@if($data->additional_information)
    		<div class="form-group additional_info">
                <strong>Additional information: </strong>
                <p>{{ $data->additional_information }}</p>
    		</div>
		@endif
	</div>	
</div>
<div class="col-md-12"><h4>Signatures</h4></div> 
<div class="row"> 
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
                <td>{{ $data->name1 }}</td>
                <td>{{ $data->designation1 }}</td>
                <td>{{ $data->company1 }}</td>
                <td>
                    @if($data->signature1)
                        {!! Html::decode(Helper::getDocType('public/', $data->signature1)) !!}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Signature2</td>
                <td>{{ $data->name2 }}</td>
                <td>{{ $data->designation2 }}</td>
                <td>{{ $data->company2 }}</td>
                <td>
                    @if($data->signature2)
                        {!! Html::decode(Helper::getDocType('public/', $data->signature2)) !!}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Signature3</td>
                <td>{{ $data->name3 }}</td>
                <td>{{ $data->designation3 }}</td>
                <td>{{ $data->company3 }}</td>
                <td>
                    @if($data->signature3)
                        {!! Html::decode(Helper::getDocType('public/', $data->signature3)) !!}
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div> 
<div class="col-md-12"><h4>Point Of Contact (POC)</h4></div> 
<div class="row"> 
    <div class="col-md-12  vander_dataview">
        <table class="table">
            <tr>
              <th>Sr.</th>
              <th>Name</th>
              <th>Email</th>
              <th>Contact</th>
            </tr>
            @php
                $pocs = json_decode($data->vendor_ary)->poc ?? array();
            @endphp
            @forelse(json_decode($pocs) as $key => $val)
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
</div>

