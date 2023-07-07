<x-user-home-layout>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading">
                                   <h1>Edit Assesment</h1>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('user.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><a href="{{ route('user.assesments') }}">Assesment</a> <span class="bread-slash">/</span>
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
                    <form method="post" action="{{ route('user.updateAssesment',$data->slug) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        
                        <!--  --> 
                        <div class="form_section batchDetail">
                            @php 
                                if(old('batch')){
                                    $b_data = \App\Models\Batch::where('slug',old('batch'))->first();
                                }else{
                                    $b_data = \App\Models\Batch::where('id',$data->batch_id)->first();
                                }
                            @endphp
                            @if($b_data)
                                <div class="col-md-12"> <h1>Batch Detail ( {{ $b_data->slug }} )</h1></div> 
                                <div class="row">
                                    <div class="col-md-12 vander_dataview">
                                        <ul>
                                              
                                            <li>
                                                <strong>Project: </strong>
                                                <p>  {{ json_decode($b_data->project_ary)->name ?? '' }}</p>
                                            </li>
                                            <li>
                                                <strong>Project Code: </strong>
                                                <p>  {{ json_decode($b_data->project_ary)->slug ?? '' }}</p>
                                            </li>
                                     
                                            <li>
                                                <strong>Training Location: </strong>
                                                <p>  {{ json_decode($b_data->location_ary)->name ?? '' }}</p>
                                            </li>
                                            <li>
                                                <strong>Training Location Code: </strong>
                                                <p>  {{ json_decode($b_data->location_ary)->slug ?? '' }}</p>
                                            </li>

                                            <li>
                                                <strong>Module: </strong>
                                                <p>  {{ json_decode($b_data->module_ary)->name ?? '' }}</p>
                                            </li>

                                            <li>
                                                <strong>Training Start Date: </strong> 
                                                <p>{{ Helper::date($b_data->start_date,'d m Y') }}</p>
                                            </li>
                                            <li>
                                                <strong>End Date: </strong> 
                                                <p>{{ Helper::date($b_data->end_date,'d m Y') }}</p>
                                            </li>

                                            <li>
                                                <strong>Start Time: </strong> 
                                                <p>{{ Helper::date($b_data->start_time,'h:i a') }}</p>
                                            </li>
                                            <li>
                                                <strong>End Date: </strong> 
                                                <p>{{ Helper::date($b_data->end_time,'h:i a') }}</p>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12"><h1>Assessment Score</h1></div> 
                                    <div class="row"> 
                                        <div class="col-md-12  vander_dataview">
                                                <table class="table">
                                                    <tr>
                                                      <th>Sr.</th>
                                                      <th>Name</th>
                                                      <th>Percent</th>
                                                      <th>Grade</th> 
                                                    </tr>
                                                    @forelse($data->batch->students as $key => $val)
                                                        @php
                                                            $g_val = \App\Models\AssesmentStudent::where(['assesment_id'=>$data->id,'student_id'=>$val->id])->first()->grade ?? '-1';
                                                        @endphp
                                                        <tr>
                                                            <td>{{++$key}}</td>
                                                            <td>{{ $val->name ?? '' }}</td>
                                                            <td>{{ $val->attendence_percent ?? '' }}</td>
                                                            <td>
                                                                @if($val->attendence_percent >= 75)
                                                                    {{ Form::select('grade['.$val->id.']',\App\Models\Assesment::grade(),$g_val,['class'=>'form-control','id'=>'grade','placeholder'=>'Choose Grade','required'=>true])}}
                                                                @else
                                                                    <p>Needed Attendance % Not Met</p>
                                                                            {{ Form::hidden('grade['.$val->id.']', '-1', ['class'=>'form-control','placeholder'=>'Grade','readonly'=>true])}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                </table>
                                        </div>
                                    </div>
                            @endif
                        </div>
                        <!--  -->
                          
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
</x-user-home-layout>