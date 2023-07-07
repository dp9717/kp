<x-admin-home-layout>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading">
                                   <h1>Edit Project</h1>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><a href="{{ route('admin.projects') }}">Project</a> <span class="bread-slash">/</span>
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
                    <form method="post" action="{{ route('admin.updateProject',$data->slug) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        <div class="form_section">
                            <div class="row">
                                <!--  -->
                                <div class="col-md-12"> <h1>Project</h1></div> 


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Name</label>
                                        {{ Form::text('name',$data->name ?? '',['class'=>'form-control','id'=>'username','placeholder'=>'Name'])}}
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                {{--<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="duration">Duration</label>
                                        {{ Form::text('duration', $data->duration ?? '',['class'=>'form-control','id'=>'duration','placeholder'=>'Duration'])}}
                                        <span class="text-danger">{{ $errors->first('duration') }}</span>
                                    </div>
                                </div>--}}

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="funded_by">Funded By</label>
                                        {{ Form::select('funded_by',$fundedby,[$data->funded_by ?? ''],['class'=>'form-control','id'=>'fundedby','placeholder'=>'Funced By'])}}
                                        <span class="text-danger">{{ $errors->first('funded_by') }}</span>
                                    </div>
                                </div>
                                @php 
                                    $sty = 'display:none';
                                    if($data->mou_signed && $data->mou_signed=='yes'){
                                        $sty = 'display:block';
                                    }
                                    $p_slug =[];
                                    $c_slug =[];
                                    $stHd_slug =[];
                                    $regHd_slug =[];
                                @endphp
                                @forelse($data->partners as $p_key => $p_val)
                                    @php
                                        $p_slug[]=\App\Models\Partner::slug($p_val->partner_id);
                                    @endphp
                                @empty
                                @endforelse
                                @forelse($data->centres as $c_key => $c_val)
                                    @php
                                        $c_slug[]=\App\Models\CentreCreation::slug($c_val->centre_creation_id);
                                    @endphp
                                @empty
                                @endforelse
                                @forelse($data->stateHead as $st_key => $st_val)
                                    @php
                                        $stHd_slug[]=\App\Models\User::slug($st_val->state_head_id);
                                    @endphp
                                @empty
                                @endforelse
                                @forelse($data->regHead as $regHd_key => $regHd_val)
                                    @php
                                        $regHd_slug[]=\App\Models\User::slug($regHd_val->regional_head_id);
                                    @endphp
                                @empty
                                @endforelse


                               {{-- <div class="col-md-4 chosen-select-single">
                                    <div class="form-group">
                                        <label for="partner">Partner</label>
                                        {{ Form::select('partner[]',$partner,$p_slug,['class'=>'form-control chosen-select','id'=>'partner','data-placeholder'=>'Partner','multiple'=>true])}}
                                        <span class="text-danger">{{ $errors->first('partner.*') }}</span>
                                    </div>
                                </div>--}}

                                <div class="col-md-4">
                                    <div class="form-group">{{$data->mou_signed}}
                                        <label for="mouSigned">MOU Singed</label>
                                        {{ Form::select('mou_signed',$mouSigned,[$data->mou_signed],['class'=>'form-control','id'=>'mouSigned','placeholder'=>'MOU Singed'])}}
                                        <span class="text-danger">{{ $errors->first('mou_signed') }}</span>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mouSec" style="{{$sty}}">
                                    <div class="form-group">
                                        <label for="mou_start_date">Start Date</label>
                                        <div class="data-custon-pick" id="syncDate">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="mou_start_date" class="form-control" id="" placeholder="Start Date" value="{{ $data->mou_start_date ?? ''}}">
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('mou_start_date') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mouSec" style="{{$sty}}">
                                    <div class="form-group">
                                        <label for="mou_end_date">End Date</label>
                                        <div class="data-custon-pick" id="syncDate2">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="mou_end_date" class="form-control" id="" placeholder="End Date" value="{{ $data->mou_end_date ?? ''}}">
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('mou_end_date') }}</span>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="centreCration">Centre</label>
                                            {{ Form::select('centre[]',$centre,$c_slug,['class'=>'form-control chosen-select','id'=>'centre','data-placeholder'=>'Centre','multiple'=>true])}}
                                            <span class="text-danger">{{ $errors->first('centre.*') }}</span>
                                        </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="target_number">Target Number</label>
                                        {{ Form::number('target_number',$data->target_number ?? '',['class'=>'form-control','id'=>'target_number','placeholder'=>'Target Number','min'=>0])}}
                                        <span class="text-danger">{{ $errors->first('target_number') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="est_fund_value">Est. Fund Value</label>
                                        {{ Form::number('est_fund_value', $data->est_fund_value ?? '',['class'=>'form-control','id'=>'est_fund_value','placeholder'=>'Est. Fund Value','min'=>0])}}
                                        <span class="text-danger">{{ $errors->first('est_fund_value') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pjManager">Project Manager</label>
                                        {{ Form::select('pjManager',$pjManager,[\App\Models\User::slug($data->project_manager_id)],['class'=>'form-control','id'=>'pjManager','placeholder'=>'Project Manager'])}}
                                        <span class="text-danger">{{ $errors->first('pjManager') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pjStateHead">State Head/SPOC</label>
                                        {{ Form::select('pjStateHead[]',$pjStateHead,$stHd_slug,['class'=>'form-control chosen-select','id'=>'pjStateHead','data-placeholder'=>'State Head/SPOC','multiple'=>true])}}
                                        <span class="text-danger">{{ $errors->first('pjStateHead.*') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pjRegionalHead">Regional/State Co-ordinator</label>
                                        {{ Form::select('pjRegionalHead[]',$pjRegionalHead,$regHd_slug,['class'=>'form-control chosen-select','id'=>'pjRegionalHead','data-placeholder'=>'Regional/State Co-ordinator','multiple'=>true])}}
                                        <span class="text-danger">{{ $errors->first('pjRegionalHead.*') }}</span>
                                    </div>
                                </div>
                                <!--  -->

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            @forelse($data->file as $fkey => $val)
                                                <div class="col-md-2 mb-2">
                                                    <div class="attc_imgs savedimg_box">
                                                            {!! Html::decode(Helper::getDocType('public/', $val->file_path)) !!}
                                                            <a href="{{route('admin.fileRemoveProject',[$val->id,$data->slug])}}" title="{{ $val->file_path }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                     </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="upload_file">Upload File</label>
                                        {{ Form::file('upload_file[]',['class'=>'form-control','id'=>'upload_file','placeholder'=>'Upload File','multiple'=>true])}}
                                        <span class="text-danger">{{ $errors->first('upload_file.*') }}</span>
                                    </div>
                                </div>

                                <!-- contribute --> 

                                <div class="form_section">
                                    <div class="col-md-12"> <h1>Partner</h1></div> 
                                    <div class="row">
                                       <div class="col-md-6">
                                         <div class="form-group">
                                              {{ Form::label('partner','Partner') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                         <div class="form-group">
                                              {{ Form::label('contribute','Contribute') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!--  -->
                                        <div class="col-md-12">
                                            @if($data->partners)
                                                @forelse($data->partners as $itemKey => $itemVal)
                                                @php
                                                    $p_slug=\App\Models\Partner::slug($itemVal->partner_id);
                                                @endphp
                                                  <div class="row w-100" id="s{{$itemKey}}">
                                                     <div class="col-md-6">
                                                       <div class="form-group">
                                                           {{ Form::select('partner[]',$partner,[$p_slug],['class'=>'form-control','id'=>'partner','placeholder'=>'Partner','required'=>true])}}
                                                          </div>
                                                      </div>
                                                      <div class="col-md-5">
                                                       <div class="form-group">
                                                           {{ Form::number('contribute[]',$itemVal->contribute,['class'=>'form-control','placeholder'=>'Contribute','required'=>true]) }}
                                                          </div>
                                                      </div>
                                                      
                                                    <div class="col-md-1 ItemRemove">
                                                     <div class="form-group">
                                                        {!! Html::decode(Form::button('<i class="fa fa-trash"></i>',['class'=>'btn btn-danger','onclick'=>"$('#s".$itemKey."').remove()"])) !!}
                                                     </div>
                                                    </div>
                                                  </div>
                                                @empty

                                                @endforelse
                                                
                                            @else
                                                <div class="row">
                                                   <div class="col-md-6">
                                                        <div class="form-group">
                                                            {{ Form::select('partner[]',$partner,[],['class'=>'form-control','id'=>'partner','placeholder'=>'Partner','required'=>true])}}
                                                            <span class="text-danger">{{ $errors->first('partner.*') }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                     <div class="form-group">
                                                          {{ Form::number('contribute[]','',['class'=>'form-control','placeholder'=>'Contribute','required'=>true,'required'=>true]) }}
                                                          <span class="text-danger">{{ $errors->first('contribute.*')}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div id="Goods">
                                            </div>
                                            <div class="col-md-12 text-right">
                                                {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                                            </div>
                                        </div>
                                    <!--  -->


                            </div>
                        </div>
                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Additional information</h1></div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{ Form::textarea('additional_information',$data->additional_information,['class'=>'form-control','id'=>'designation','placeholder'=>'Additional information'])}}
                                            <span class="text-danger">{{ $errors->first('additional_information') }}</span>
                                        </div>
                                    </div>
                            </div>
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
</x-admin-home-layout>
@php
$p = Form::select('partner[]',$partner,[],['class'=>'form-control','id'=>'partner','placeholder'=>'Partner','required'=>true]);

@endphp
<script type="text/javascript">
  $('#mouSigned').change(function(){
        if($(this).val()=='yes'){
            $('.mouSec').show();
        }else{
            $('.mouSec').hide();
        }
    });
/*contribute */
    $('.plus').click(function(){
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"><div class="col-md-6"> <div class="form-group">{{$p}}</div></div><div class="col-md-5"> <div class="form-group"> <input class="form-control" placeholder="Contribute" required name="contribute[]" type="number"> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash"></i></button></div></div></div>';
    $('#Goods').append(clone);
    var cls = $('.Goods').length;
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
    if (cls) {
      $('.trash').show();
    }
  });
  function removeItemRow(argument) {
   // alert();
    $('#removeItemRow'+argument).remove();
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
  }
</script>