<div class="vander_dataview">
    <ul>
          
        <li>
            <strong>Project: </strong>
            <p>  {{ json_decode($data->project_ary)->name ?? '' }}</p>
        </li>
        <li>
            <strong>Project Code: </strong>
            <p>  {{ json_decode($data->project_ary)->slug ?? '' }}</p>
        </li>
 
        <li>
            <strong>Training Centre: </strong>
            <p>  {{ json_decode($data->location_ary)->name ?? '' }}</p>
        </li>
        <li>
            <strong>Training Centre Code: </strong>
            <p>  {{ json_decode($data->location_ary)->slug ?? '' }}</p>
        </li>

        <li>
            <strong>Trainer Name: </strong>
            <p>  {{ json_decode($data->trainer_ary)->name ?? '' }}</p>
        </li>
        <li>
            <strong>Trainer Code: </strong>
            <p>  {{ json_decode($data->trainer_ary)->slug ?? '' }}</p>
        </li>

        <li>
            <strong>State Co-Ordinator Name: </strong>
            <p>  {{ json_decode($data->state_co_ordinator_ary)->name ?? '' }}</p>
        </li>
        <li>
            <strong>State Co-Ordinator Code: </strong>
            <p>  {{ json_decode($data->state_co_ordinator_ary)->slug ?? '' }}</p>
        </li>

        <li>
            <strong>Module: </strong>
            <p>  {{ json_decode($data->module_ary)->name ?? '' }}</p>
        </li>

        <li>
            <strong>Training Start Date: </strong> 
            <p>{{ Helper::date($data->start_date,'d m Y') }}</p>
        </li>
        <li>
            <strong>End Date: </strong> 
            <p>{{ Helper::date($data->end_date,'d m Y') }}</p>
        </li>

        <li>
            <strong>Start Time: </strong> 
            <p>{{ Helper::date($data->start_time,'h:i a') }}</p>
        </li>
        <li>
            <strong>End Date: </strong> 
            <p>{{ Helper::date($data->end_time,'h:i a') }}</p>
        </li>

        <li>
            <strong>Status: </strong>
            <p>  {{ \App\Models\Batch::status($data->status) }}</p>
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
        <h4>State Head Approval</h4>
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
@if($data->third_level_id)

    <div class="vander_dataview">
        <h4>HO Admin Approval</h4>
        <ul>
            <li>
                <strong>Name: </strong> 
                <p>{{ \App\Models\User::userAry($data->third_level_id)->name ?? (json_decode($data->third_level_ary)->name ?? '') }}</p>
            </li>
            <li>
                <strong>Email: </strong> 
                <p> {{ \App\Models\User::userAry($data->third_level_id)->email ?? (json_decode($data->third_level_ary)->email ?? '') }}</p>
            </li>
            <li>
                <strong>Code: </strong> 
                <p>{{ \App\Models\User::userAry($data->third_level_id)->mobile ?? (json_decode($data->third_level_ary)->mobile ?? '') }}</p>
            </li>
            <li>
                <strong>Date: </strong> 
                <p>{{ Helper::date($data->third_level_date) }}</p>
            </li>
            @if($data->admin_third_level_approval)
                <li>
                    <strong>Approved by Admin: </strong> 
                </li> 
            @endif
        </ul>
    </div>

        <div class="form-group additional_info">
            <strong>Comment: </strong>
            <p>{{ $data->third_level_comment }}</p>
        </div>
@endif
@if($data->fourth_level_id)

    <div class="vander_dataview">
        <h4>( HO-PM / Director / Trustee ) Approval</h4>
        <ul>
            <li>
                <strong>Name: </strong> 
                <p>{{ \App\Models\User::userAry($data->fourth_level_id)->name ?? (json_decode($data->fourth_level_ary)->name ?? '') }}</p>
            </li>
            <li>
                <strong>Email: </strong> 
                <p> {{ \App\Models\User::userAry($data->fourth_level_id)->email ?? (json_decode($data->fourth_level_ary)->email ?? '') }}</p>
            </li>
            <li>
                <strong>Code: </strong> 
                <p>{{ \App\Models\User::userAry($data->fourth_level_id)->mobile ?? (json_decode($data->fourth_level_ary)->mobile ?? '') }}</p>
            </li>
            <li>
                <strong>Date: </strong> 
                <p>{{ Helper::date($data->fourth_level_date) }}</p>
            </li>
            @if($data->admin_fourth_level_approval)
                <li>
                    <strong>Approved by Admin: </strong> 
                </li> 
            @endif
        </ul>
    </div>

        <div class="form-group additional_info">
            <strong>Comment: </strong>
            <p>{{ $data->fourth_level_comment }}</p>
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
        <div class="vander_dataview">
            <h4>YLTP</h4>
            <ul>
                <li>
                    <strong>Course Start Date: </strong> 
                    <p>{{ Helper::date($data->course_start_date) }}</p>
                </li>
                 <li>
                    <strong>Course End Date: </strong> 
                    <p>{{ Helper::date($data->course_end_date) }}</p>
                </li>
            </ul>
            @if($data->course_teacher)
                  <table class="table">
                    <tr>
                      <th>Sr.</th>
                      <th>Teacher Name</th>
                      <th>Code</th>
                    </tr>
                    @forelse(json_decode($data->course_teacher) as $itemKey => $itemVal)
                        <tr>
                            <td>{{++$itemKey}}</td>
                            <td>{{ $itemVal->name ?? '' }}</td>
                            <td>{{ $itemVal->code ?? '' }}</td>
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
        <h6>Student</h6>
        <div class="row">
            @if($data->students)
                  <table class="table">
                    <tr>
                      <th>Sr.</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Contact</th>
                    </tr>
                    @forelse($data->students as $itemKey => $itemVal)
                        <tr>
                            <td>{{++$itemKey}}</td>
                            <td>{{ $itemVal->name ?? '' }}</td>
                            <td>{{ $itemVal->email ?? '' }}</td>
                            <td>{{ $itemVal->contact ?? '' }}</td>
                        </tr>
                    @empty
                    @endforelse
                  </table>
              @endif
        </div>
    </div>
</div>

