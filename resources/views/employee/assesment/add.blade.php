<x-user-home-layout>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading">
                                   <h1>Add Assesment</h1>
                                </div> 
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('user.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><a href="{{ route('user.assesments') }}">Assesment</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><span class="bread-blod">Add</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                       
                        <!--  -->
                    </div>
                </div>
                <!-- pro -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form method="post" action="{{ route('user.saveAssesment') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Assesment</h1></div> 


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Batch</label>
                                        {{ Form::select('batch',$batch,[],['class'=>'form-control','id'=>'batch','placeholder'=>'Choose Batch','required'=>true])}}
                                        <span class="text-danger">{{ $errors->first('batch') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <!--  --> 
                        <div class="form_section batchDetail">
                            @if(old('batch'))
                                @php $data = \App\Models\Batch::where('slug',old('batch'))->first(); @endphp
                                @if($data)
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
                                                @endforelse
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <!--  -->
                                      
                        <div class="col-md-12 form_btnbox">
                            <button type="submit" class="btn btn-custon-save btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
                <!-- end pro -->
                
                <!--  -->
               
            </div>
            
        </div>
    </div>
</x-user-home-layout>
<script type="text/javascript">
$(document).ready(function () {
    $(document).on('change', '#batch', function() {
      var slug = $(this).val();
      if (slug) {
          var url="{{ route('user.ajaxUserView') }}";
            $.ajax({
              type:"POST",
              url:url,
              data:{slug:slug , _token: '{{csrf_token()}}',type:'assesmentStudentView'},
              beforeSend: function(){
              // $('#preloader').show();
              },
              success:function(response){
                if (response) {
                    $('.batchDetail').empty().html(response);
                    // $('#PrimaryModalhdbgcl .modal-body').html(response);
                    // $('#PrimaryModalhdbgcl').modal('show');
                }
               // $('#preloader').hide();
              }
            });
      }
    });
  });

</script>