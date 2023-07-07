<div class="vander_dataview">
    <ul>
          <li>
            <strong>Name: </strong> 
            <p>{{ $data->name }}</p>
        </li>
       <li>
            <strong>GST: </strong> 
            <p>{{ $data->gst }}</p>
        </li>
        <li>
            <strong>Pan: </strong> 
            <p>{{ $data->pan }}</p>
        </li>
        <li>
            <strong>CIN: </strong> 
            <p>{{ $data->cin }}</p>
        </li>
         

        @if(isset($data->full_address) && $data->full_address)
            <li>
                <strong>Address: </strong>
                <p> @php $add = json_Decode($data->full_address); @endphp
                    @if($add)
                        {{  $add->address ?? '' }} , {{  $add->taluk ?? '' }} ,
                    {{  $add->city ?? '' }} , {{  $add->state ?? '' }} , {{  $add->pincode ?? '' }}
                    @endif</p>
            </li>
        @endif 

        <li>
            <strong>Status: </strong>
            <p>  {{ \App\Models\Vendor::status($data->status) }}</p>
        </li>

    </ul>
</div>


@if($data->additional_information)
    <div class="form-group additional_info">
                <strong>Additional information: </strong>
                <p>{{ $data->additional_information }}</p>
    </div>
@endif
   
<div class="vander_dataview">
    <h4>Created By</h4>
    <ul>
        <li>
            <strong>name: </strong> 
            <p>{{ \App\Models\User::userAry($data->user_id)->name ?? (json_decode($data->user_ary)->name ?? '') }}</p>
        </li>
        <li>
            <strong>Email: </strong> 
            <p>{{ \App\Models\User::userAry($data->user_id)->email ?? (json_decode($data->user_ary)->email ?? '') }}</p>
        </li>
        <li>
            <strong>Code: </strong> 
            <p>{{ \App\Models\User::userAry($data->user_id)->slug ?? (json_decode($data->user_ary)->slug ?? '') }}</p>
        </li>
        <li>
            <strong>Date: </strong> 
            <p>{{ Helper::date($data->created_at) }}</p>
        </li>
    </ul>
</div>

  
@if($data->second_level_id)

    <div class="vander_dataview">
        <h4>Approved By</h4>
        <ul>
            <li>
                <strong>Name: </strong> 
                <p>{{ \App\Models\User::userAry($data->second_level_id)->name ?? (json_decode($data->second_level_ary)->name ?? '') }}</p>
            </li>
            <li>
                <strong>Email: </strong> 
                <p> {{ \App\Models\User::userAry($data->second_level_id)->email ?? (json_decode($data->second_level_ary)->email ?? '') }}</p>
            </li>
            <li>
                <strong>Code: </strong> 
                <p>{{ \App\Models\User::userAry($data->second_level_id)->mobile ?? (json_decode($data->second_level_ary)->mobile ?? '') }}</p>
            </li>
            <li>
                <strong>Date: </strong> 
                <p>{{ Helper::date($data->second_level_date) }}</p>
            </li>
            @if($data->admin_second_level_approval)
                <li>
                    <strong>Approved by Admin </strong> 
                </li> 
            @endif
        </ul>
    </div>

        <div class="form-group additional_info">
            
                    <strong>Comment: </strong>
                    <p>{{ $data->second_level_comment }}</p>
                
        </div>

@endif

@if($data->status==2)
    <div class="vander_dataview">
        <h4>Rejected By</h4>
        <ul>
            <li>
                <strong>Name: </strong> 
                <p>{{ \App\Models\User::userAry($data->rejected_by_id)->name ?? (json_decode($data->rejected_by_ary)->name ?? '') }}</p>
            </li>
            <li>
                <strong>Email: </strong> 
                <p> {{ \App\Models\User::userAry($data->rejected_by_id)->email ?? (json_decode($data->rejected_by_ary)->email ?? '') }}</p>
            </li>
            <li>
                <strong>Code: </strong> 
                <p>{{ \App\Models\User::userAry($data->rejected_by_id)->mobile ?? (json_decode($data->rejected_by_ary)->mobile ?? '') }}</p>
            </li><li>
                <strong>Date: </strong> 
                <p>{{ Helper::date($data->rejected_by_date) }}</p>
            </li>
        </ul>
    </div>
    <div class="form-group additional_info">
            
                <strong>Comment: </strong>
                <p>{{ $data->rejected_by_comment }}</p>
            
    </div>
@endif
<div class="attachment_sec">
    <div class="col-md-12">
        <h6>Uploads</h6>
        <div class="row">
            @forelse($data->file as $fkey => $val)
                <div class="col-md-3 form-group">
                        <strong></strong> 
                        <div class="attc_imgs">
                            <a href="{{ asset('public/'.$val->file_path) }}" title="{{ $val->file_path }}" target="_blank">
                                {!! Html::decode(Helper::getDocType('public/', $val->file_path)) !!}
                            </a>
                        </div>
                    </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
<div class="attachment_sec">
    <div class="col-md-12">
        <h6>POC</h6>
        <div class="row">
            @if($data->poc)

                @php $item=json_decode($data->poc); @endphp
                  <table class="table">
                    <tr>
                      <th>Sr.</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Contact</th>
                    </tr>
                    @forelse($item as $itemKey => $itemVal)
                        <tr>
                        <td>{{++$itemKey}}</td>
                        <td>{{ $itemVal->poc_name ?? '' }}</td>
                        <td>{{ $itemVal->poc_email ?? '' }}</td>
                        <td>{{ $itemVal->poc_contact ?? '' }}</td>
                      </tr>
                    @empty
                    @endforelse
                  </table>
              @endif
        </div>
    </div>
</div>

<div class="attachment_sec">
    <div class="col-md-12">
        <h6>Director</h6>
        <div class="row">
            @if($data->director)

                @php $item=json_decode($data->director); @endphp
                  <table class="table">
                    <tr>
                      <th>Sr.</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Contact</th>
                    </tr>
                    @forelse($item as $itemKey => $itemVal)
                        <tr>
                        <td>{{++$itemKey}}</td>
                        <td>{{ $itemVal->director_name ?? '' }}</td>
                        <td>{{ $itemVal->director_email ?? '' }}</td>
                        <td>{{ $itemVal->director_contact ?? '' }}</td>
                      </tr>
                    @empty
                    @endforelse
                  </table>
              @endif
        </div>
    </div>
</div>

<div class="attachment_sec">
    <div class="col-md-12">
        <h6>Project</h6>
        <div class="row">
            @if($data->projectPartner)
                  <table class="table">
                    <tr>
                      <th>Sr.</th>
                      <th>Name</th>
                      <th>Unique code</th>
                      <th>Contribution</th>
                    </tr>
                    @forelse($data->projectPartner as $itemKey => $itemVal)
                        <tr>
                        <td>{{++$itemKey}}</td>
                        <td>{{ $itemVal->project->name ?? '' }}</td>
                        <td>{{ $itemVal->project->slug ?? '' }}</td>
                        <td>{{ $itemVal->contribute ?? '' }}</td>
                      </tr>
                    @empty
                    @endforelse
                  </table>
              @endif
        </div>
    </div>
</div>

