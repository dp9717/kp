<x-user-home-layout>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading">
                                   <h1>Add Attendence</h1>
                                </div> 
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('user.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><a href="{{ route('user.attendences') }}">Attendence</a> <span class="bread-slash">/</span>
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
                    <form method="post" action="{{ route('user.saveAttendence') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Attendence</h1></div> 


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Batch</label>
                                        {{ Form::select('batch',$batch,[],['class'=>'form-control','id'=>'batch','placeholder'=>'Choose Batch','required'=>true])}}
                                        <span class="text-danger">{{ $errors->first('batch') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Attendence Date</label>
                                        {{--<div class="data-custon-pick" id="syncDate">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="attendence_date" class="form-control" id="" placeholder="Attendence Date" value="{{ date('d-m-Y') }}">
                                            </div>
                                        </div>--}}
                                        {{ Form::date('attendence_date',date('Y-m-d'),['class'=>'form-control','id'=>'attendence_date','placeholder'=>'Attendence Date','required'=>true,'readonly'=>true])}}
                                        <span class="text-danger">{{ $errors->first('attendence_date') }}</span>
                                    </div>
                                </div>
                            <!--  -->
                                
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
                                    <div class="col-md-12"><h1>Students</h1></div> 
                                    <div class="row"> 
                                        <div class="col-md-12  vander_dataview">
                                                <table class="table">
                                                    <tr>
                                                      <th>Sr.</th>
                                                      <th>Name</th>
                                                      <th>Percent</th>
                                                      <th>Attendence</th>
                                                    </tr>
                                                    @forelse($data->students as $key => $val)
                                                        <tr>
                                                            <td>{{++$key}}</td>
                                                            <td>{{ $val->name ?? '' }}</td>
                                                            <td>{{ $val->attendence_percent.'%' }}</td>
                                                            <td>
                                                                @forelse(\App\Models\Attendence::attendenceAry() as $p_key => $p_val)
                                                                    <div class="checkbox-inline i-checks pull-left attendenceBtn">
                                                                        <label>
                                                                            <input type="radio" value="{{$p_key}}" class="iradio_square-green" name="attendence[{{$val->id}}]" required> <i></i> {{$p_val}}
                                                                        </label>
                                                                    </div>
                                                                    <span class="text-danger">{{ $errors->first('attendence.*') }}</span>
                                                                @empty
                                                                @endforelse
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
              data:{slug:slug , _token: '{{csrf_token()}}',type:'attendenceStudentView'},
              beforeSend: function(){
              // $('#preloader').show();
              },
              success:function(response){
                if (response) {
                    $('.batchDetail').empty().html(response).show();
                    // $('#PrimaryModalhdbgcl .modal-body').html(response);
                    // $('#PrimaryModalhdbgcl').modal('show');
                }
               // $('#preloader').hide();
              }
            });
      }else{
        $('.batchDetail').empty().hide();
      }
    });
  });

</script>