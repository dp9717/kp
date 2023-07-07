<div class="vander_dataview">
    <ul>
          <li>
            <strong>Name: </strong> 
            <p>{{ $data->name ?? '' }}</p>
        </li>
       <!-- <li>
            <strong>Duration: </strong> 
            <p>{{-- $data->duration ?? '' --}}</p>
        </li>
 -->
        <li>
            <strong>Funded By: </strong> 
            <p>{{ $data->funded_by ? (\App\Models\Project::fundedby($data->funded_by) ?? '') : '' }}</p>
        </li>
        <li>
            <strong>Status: </strong>
            <p>  {{ \App\Models\Project::status($data->status) }}</p>
        </li>

        <li>
            <strong>Target Number: </strong> 
            <p>{{ $data->target_number ?? '' }}</p>
        </li>

        <li>
            <strong>EST Fund Value: </strong> 
            <p>{{ $data->est_fund_value ?? '' }}</p>
        </li>

        <li>
            <strong>MOU Signed: </strong> 
            <p>{{ ucwords($data->mou_signed ?? '') }}</p>
        </li>
        @if($data->mou_signed && $data->mou_signed=='yes')
            <li>
                <strong>State Date: </strong> 
                <p>{{ $data->mou_start_date ? Helper::date($data->mou_start_date,'d m Y') : '' }}</p>
            </li>
            <li>
                <strong>End Date: </strong> 
                <p>{{ $data->mou_end_date ? Helper::date($data->mou_end_date,'d m Y') : '' }}</p>
            </li>
        @endif

        <li>
            <strong>Project Manager: </strong> 
            <p>{{ $data->manager->name ?? '' }}</p>
        </li>
        <li>
            <strong>Project Manager Code: </strong> 
            <p>{{ $data->manager->slug ?? '' }}</p>
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
            <strong>Code: </strong> 
            <p>{{ \App\Models\User::userAry($data->user_id)->slug ?? (json_decode($data->user_ary)->slug ?? '') }}</p>
        </li>
        <li>
            <strong>Email: </strong> 
            <p>{{ \App\Models\User::userAry($data->user_id)->email ?? (json_decode($data->user_ary)->email ?? '') }}</p>
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
            </li><li>
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
    <h6>Uploads</h6>
    <div class="col-md-12">
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
        <h6>Centre</h6>
        <div class="row">
                <table class="table">
                    <tr>
                      <th>Sr.</th>
                      <th>Name</th>
                      <th>Code </th>
                    </tr>
                    @forelse($data->centres as $c_key => $c_val)

                        <tr>
                            <td>{{++$c_key}}</td>
                            <td>{{ $c_val->centreCreation->name ?? '' }}</td>
                            <td>{{ $c_val->centreCreation->slug ?? '' }}</td>
                      </tr>
                    @empty
                    @endforelse
                </table>
           
        </div>
    </div>
</div>

<div class="attachment_sec">
    <div class="col-md-12">
        <h6>Partner</h6>
        <div class="row">
                <table class="table">
                    <tr>
                      <th>Sr.</th>
                      <th>Name</th>
                      <th>Code </th>
                      <th>Contribute </th>
                    </tr>
                    @forelse($data->partners as $p_key => $p_val)

                        <tr>
                            <td>{{++$p_key}}</td>
                            <td>{{ $p_val->partner->name ?? '' }}</td>
                            <td>{{ $p_val->partner->slug ?? '' }}</td>
                            <td>{{ $p_val->contribute ?? '' }}</td>
                      </tr>
                    @empty
                    @endforelse
                </table>
           
        </div>
    </div>
</div>

<div class="attachment_sec">
    <div class="col-md-12">
        <h6>State Head/SPOC</h6>
        <div class="row">
            <table class="table">
                <tr>
                  <th>Sr.</th>
                  <th>Name</th>
                  <th>Code </th>
                </tr>
                @forelse($data->stateHead as $stHd_key => $stHd_val)

                    <tr>
                        <td>{{++$stHd_key}}</td>
                        <td>{{ $stHd_val->stateHead->name ?? '' }}</td>
                        <td>{{ $stHd_val->stateHead->slug ?? '' }}</td>
                  </tr>
                @empty
                @endforelse
            </table>
        </div>
    </div>
</div>

<div class="attachment_sec">
    <div class="col-md-12">
        <h6>Regional/State Head</h6>
        <div class="row">
            <table class="table">
                <tr>
                  <th>Sr.</th>
                  <th>Name</th>
                  <th>Code </th>
                </tr>
                @forelse($data->regHead as $rgHd_key => $rgHd_val)
                    <tr>
                        <td>{{++$rgHd_key}}</td>
                        <td>{{ $rgHd_val->regStateHead->name ?? '' }}</td>
                        <td>{{ $rgHd_val->regStateHead->slug ?? '' }}</td>
                  </tr>
                @empty
                @endforelse
            </table>
        </div>
    </div>
</div>