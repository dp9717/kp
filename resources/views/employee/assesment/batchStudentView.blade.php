<div class="col-md-12"> <h1>Batch Detail ( {{ $data->slug }} )</h1></div> 
<div class="row">
    <div class="col-md-12 vander_dataview">
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
                <strong>Training Location: </strong>
                <p>  {{ json_decode($data->location_ary)->name ?? '' }}</p>
            </li>
            <li>
                <strong>Training Location Code: </strong>
                <p>  {{ json_decode($data->location_ary)->slug ?? '' }}</p>
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

        </ul>
    </div>
</div>
<div class="col-md-12"><h1>Students</h1></div> 
<div class="row"> 
    <div class="col-md-12  vander_dataview">
            <table class="table">
                <tr>
                  <th>Sr.</th>
                  <th>Name</th>
                  <th>Percent</th>
                  <th>Grade</th>
                </tr>
                @php
                    $students = $data->students->where('attendence_percent', '>=', 75);
                @endphp
                @forelse($data->students as $key => $val)
                    
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{ $val->name ?? '' }}</td>
                            <td>{{ $val->attendence_percent.'%' }}</td>
                            <td>
                                @if($val->attendence_percent >= 75)
                                    {{ Form::select('grade['.$val->id.']',\App\Models\Assesment::grade(),[],['class'=>'form-control','placeholder'=>'Choose Grade','required'=>true])}}
                                @else
                                    <p>Needed Attendance % Not Met</p>
                                    {{ Form::hidden('grade['.$val->id.']', 'None', ['class'=>'form-control','placeholder'=>'Grade','readonly'=>true])}}
                                @endif
                            </td>
                        </tr>
                @empty
                    <tr>
                        <td colspan="4">Students not found</td>
                    </tr>
                @endforelse
            </table>
    </div>
</div>