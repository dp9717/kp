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
                <strong>End Time: </strong> 
                <p>{{ Helper::date($data->batch->end_time,'h:i a') }}</p>
            </li>

        </ul>
    </div>
</div>
<div class="col-md-12"><h4>Students Assesment Detail</h4></div> 
<div class="row"> 
    <div class="col-md-12  vander_dataview">
            <table class="table">
                <tr>
                  <th>Sr.</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Percent</th>
                  <th>Grade</th>
                </tr>
                @forelse($data->batch->students as $key => $val)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{ $val->name ?? '' }}</td>
                        <td>{{ $val->email ?? '' }}</td>
                        <td>{{ $val->contact ?? '' }}</td>
                        <td>{{ $val->attendence_percent ?? 0 }}%</td>
                        <td>{{ \App\Models\Assesment::grade(\App\Models\AssesmentStudent::where(['assesment_id'=>$data->id,'student_id'=>$val->id])->first()->grade ?? '-1') }}</td>
                    </tr>
                @empty
                @endforelse
            </table>
    </div>

</div>

