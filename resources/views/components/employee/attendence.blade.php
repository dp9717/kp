<div class="row">
    <div class="col-md-12 vander_dataview">
        <ul>
              
            <li>
                <strong>Project: </strong>
                <p>  {{ json_decode($data->batch->project_ary)->name ?? '' }}</p>
            </li>
            <li>
                <strong>Project Code: </strong>
                <p>  {{ json_decode($data->batch->project_ary)->slug ?? '' }}</p>
            </li>

            <li>
                <strong>Trainer: </strong>
                <p>  {{ json_decode($data->batch->trainer_ary)->name ?? '' }}</p>
            </li>
            
            <li>
                <strong>Trainer Code: </strong>
                <p>  {{ json_decode($data->batch->trainer_ary)->slug ?? '' }}</p>
            </li>
     
            <li>
                <strong>Training Location: </strong>
                <p>  {{ json_decode($data->batch->location_ary)->name ?? '' }}</p>
            </li>
            <li>
                <strong>Training Location Code: </strong>
                <p>  {{ json_decode($data->batch->location_ary)->slug ?? '' }}</p>
            </li>

            <li>
                <strong>Module: </strong>
                <p>  {{ json_decode($data->batch->module_ary)->name ?? '' }}</p>
            </li>

            <li>
                <strong>Training Start Date: </strong> 
                <p>{{ Helper::date($data->batch->start_date,'d m Y') }}</p>
            </li>
            <li>
                <strong>End Date: </strong> 
                <p>{{ Helper::date($data->batch->end_date,'d m Y') }}</p>
            </li>

            <li>
                <strong>Start Time: </strong> 
                <p>{{ Helper::date($data->batch->start_time,'h:i a') }}</p>
            </li>
            <li>
                <strong>End Date: </strong> 
                <p>{{ Helper::date($data->batch->end_time,'h:i a') }}</p>
            </li>

        </ul>
    </div>
</div>
<div class="col-md-12"><h4>Students Attendence Detail</h4></div> 
<div class="row"> 
    <div class="col-md-12  vander_dataview">
            <table class="table">
                <tr>
                  <th>Sr.</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Percent</th>
                  <th>Attendence</th>
                </tr>
                @forelse($data->batch->students as $key => $val)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{ $val->name ?? '' }}</td>
                        <td>{{ $val->email ?? '' }}</td>
                        <td>{{ $val->contact ?? '' }}</td>
                        <td>{{ $val->attendence_percent ?? 0 }}%</td>
                        <td>
                            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo{{$key}}"><i class="fa fa-plus"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <div id="demo{{$key}}" class="collapse out">
                                <table class="table">
                                    <tr>
                                        <th>Date:</th>
                                        <th>Attendence:</th>
                                    </tr>
                                        @forelse(\App\Models\Attendence::where(['batch_id'=>$data->batch_id])->orderBy('attendence_date','asc')->get() as $p_key => $p_val)
                                                @forelse(\App\Models\AttendenceStudent::where(['attendence_id'=>$p_val->id,'student_id'=>$val->id])->get() as $s_key => $s_val)
                                                    <tr>
                                                        <td>{{ Helper::date($p_val->attendence_date,'d M Y') }}</td>
                                                        <td>{{ \App\Models\Attendence::attendenceAry($s_val->attendence) }}</td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                        @empty
                                        @endforelse
                                </table>
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
            </table>
    </div>

</div>
