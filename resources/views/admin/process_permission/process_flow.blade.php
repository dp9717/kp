<x-admin-home-layout>

<div class="main-content">
    <div class="container-fluid">
         @if(count($process))
            <div class="row">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading">
                                 <h1>Process</h1>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><span class="bread-blod">Process Flow</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                       
                        <!--  -->
                    </div>
                </div>

                <!-- pro -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form method="post" action="{{ route('admin.process_flow_save') }}" class="mt-6 space-y-6">
                        @csrf 
                         <div class="form_section">
                            <div class="row process_work_flow">
                            	@forelse($process as $key => $val)
                                        @if($key==1)
                                            <div class="col-md-12">
                                                <h1>{{ $val }}</h1>
                                                    @forelse(\App\Models\CentreCreation::statusAssign() as $s_key =>$s_val)
                                                        <div class="row">
                                                           <div class="col-md-12">
                                                             <h4>{{ Helper::processStatusLevel(1,$s_val) }}</h4>
                                                         </div>
                                                            @forelse(\App\Models\Role::rolePluck() as $p_key => $p_val)
                                                            @php
                                                                $rold_id = \App\Models\Role::id($p_key);
                                                                $chk = \App\Models\ProcessAppFlow::where(['role_id'=>$rold_id,'process_id'=>$key,'status_id'=>$s_val])->count();
                                                            @endphp
                                                            <div class="col-md-3">
                                                                <div class="i-checks pull-left">
                                                                    <label>
                                                                        <input type="checkbox" value="{{$p_key}}" class="role_process_chk" name="process_flow[{{$key}}][{{$s_val}}][]" @if($chk) checked @endif > <i></i> {{$p_val}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    @empty
                                                    @endforelse
                                            </div>
                                		@elseif($key==2)
                                            <div class="col-md-12">

                                                <h1>{{ $val }}</h1>
                                                    @forelse(\App\Models\CentreCreation::statusAssign() as $s_key =>$s_val)
                                                        <div class="row">
                                                           <div class="col-md-12">
                                                             <h4>{{ Helper::processStatusLevel(2,$s_val) }}</h4>
                                                         </div>
                                                            @forelse(\App\Models\Role::rolePluck() as $p_key => $p_val)
                                                            @php
                                                                $rold_id = \App\Models\Role::id($p_key);
                                                                $chk = \App\Models\ProcessAppFlow::where(['role_id'=>$rold_id,'process_id'=>$key,'status_id'=>$s_val])->count();
                                                            @endphp
                                                            <div class="col-md-3">
                                                                <div class="i-checks pull-left">
                                                                    <label>
                                                                        <input type="checkbox" value="{{$p_key}}" class="role_process_chk" name="process_flow[{{$key}}][{{$s_val}}][]" @if($chk) checked @endif > <i></i> {{$p_val}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    @empty
                                                    @endforelse
                                            </div>
                                        @elseif($key==3)
                                            <div class="col-md-12">

                                                <h1>{{ $val }}</h1>
                                                    @forelse(\App\Models\Batch::statusAssign() as $s_key =>$s_val)
                                                        <div class="row">
                                                           <div class="col-md-12">
                                                             <h4>{{ Helper::processStatusLevel(3,$s_val) }}</h4>
                                                         </div>
                                                            @forelse(\App\Models\Role::rolePluck() as $p_key => $p_val)
                                                            @php
                                                                $rold_id = \App\Models\Role::id($p_key);
                                                                $chk = \App\Models\ProcessAppFlow::where(['role_id'=>$rold_id,'process_id'=>$key,'status_id'=>$s_val])->count();
                                                            @endphp
                                                            <div class="col-md-3">
                                                                <div class="i-checks pull-left">
                                                                    <label>
                                                                        <input type="checkbox" value="{{$p_key}}" class="role_process_chk" name="process_flow[{{$key}}][{{$s_val}}][]" @if($chk) checked @endif > <i></i> {{$p_val}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    @empty
                                                    @endforelse
                                            </div>
                                        @elseif($key==4)
                                            <div class="col-md-12">
                                                <h1>{{ $val }}</h1>
                                                    @forelse(\App\Models\CentreCreation::statusAssign() as $s_key =>$s_val)
                                                        <div class="row">
                                                           <div class="col-md-12">
                                                             <h4>{{ Helper::processStatusLevel(4,$s_val) }}</h4>
                                                         </div>
                                                            @forelse(\App\Models\Role::rolePluck() as $p_key => $p_val)
                                                            @php
                                                                $rold_id = \App\Models\Role::id($p_key);
                                                                $chk = \App\Models\ProcessAppFlow::where(['role_id'=>$rold_id,'process_id'=>$key,'status_id'=>$s_val])->count();
                                                            @endphp
                                                            <div class="col-md-3">
                                                                <div class="i-checks pull-left">
                                                                    <label>
                                                                        <input type="checkbox" value="{{$p_key}}" class="role_process_chk" name="process_flow[{{$key}}][{{$s_val}}][]" @if($chk) checked @endif > <i></i> {{$p_val}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    @empty
                                                    @endforelse
                                            </div>
                                        @elseif($key==5)
                                            <div class="col-md-12">
                                                <h1>{{ $val }}</h1>
                                                    @forelse(\App\Models\CentreCreation::statusAssign() as $s_key =>$s_val)
                                                        <div class="row">
                                                           <div class="col-md-12">
                                                             <h4>{{ Helper::processStatusLevel(5,$s_val) }}</h4>
                                                         </div>
                                                            @forelse(\App\Models\Role::rolePluck() as $p_key => $p_val)
                                                            @php
                                                                $rold_id = \App\Models\Role::id($p_key);
                                                                $chk = \App\Models\ProcessAppFlow::where(['role_id'=>$rold_id,'process_id'=>$key,'status_id'=>$s_val])->count();
                                                            @endphp
                                                            <div class="col-md-3">
                                                                <div class="i-checks pull-left">
                                                                    <label>
                                                                        <input type="checkbox" value="{{$p_key}}" class="role_process_chk" name="process_flow[{{$key}}][{{$s_val}}][]" @if($chk) checked @endif > <i></i> {{$p_val}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    @empty
                                                    @endforelse
                                            </div>
                                        @elseif($key==8)
                                            <div class="col-md-12">
                                                <h1>{{ $val }}</h1>
                                                    @forelse(\App\Models\Attendence::statusAssign() as $s_key =>$s_val)
                                                        <div class="row">
                                                           <div class="col-md-12">
                                                             <h4>{{ Helper::processStatusLevel(8,$s_val) }}</h4>
                                                         </div>
                                                            @forelse(\App\Models\Role::rolePluck() as $p_key => $p_val)
                                                            @php
                                                                $rold_id = \App\Models\Role::id($p_key);
                                                                $chk = \App\Models\ProcessAppFlow::where(['role_id'=>$rold_id,'process_id'=>$key,'status_id'=>$s_val])->count();
                                                            @endphp
                                                            <div class="col-md-3">
                                                                <div class="i-checks pull-left">
                                                                    <label>
                                                                        <input type="checkbox" value="{{$p_key}}" class="role_process_chk" name="process_flow[{{$key}}][{{$s_val}}][]" @if($chk) checked @endif > <i></i> {{$p_val}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    @empty
                                                    @endforelse
                                            </div>
                                        @elseif($key==9)
                                            <div class="col-md-12">
                                                <h1>{{ $val }}</h1>
                                                    @forelse(\App\Models\Assesment::statusAssign() as $s_key =>$s_val)
                                                        <div class="row">
                                                           <div class="col-md-12">
                                                             <h4>{{ Helper::processStatusLevel(9,$s_val) }}</h4>
                                                         </div>
                                                            @forelse(\App\Models\Role::rolePluck() as $p_key => $p_val)
                                                            @php
                                                                $rold_id = \App\Models\Role::id($p_key);
                                                                $chk = \App\Models\ProcessAppFlow::where(['role_id'=>$rold_id,'process_id'=>$key,'status_id'=>$s_val])->count();
                                                            @endphp
                                                            <div class="col-md-3">
                                                                <div class="i-checks pull-left">
                                                                    <label>
                                                                        <input type="checkbox" value="{{$p_key}}" class="role_process_chk" name="process_flow[{{$key}}][{{$s_val}}][]" @if($chk) checked @endif > <i></i> {{$p_val}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    @empty
                                                    @endforelse
                                            </div>
                                        @elseif($key==10)
                                            <div class="col-md-12">
                                                <h1>{{ $val }}</h1>
                                                    @forelse(\App\Models\Certificate::statusAssign() as $s_key =>$s_val)
                                                        <div class="row">
                                                           <div class="col-md-12">
                                                             <h4>{{ Helper::processStatusLevel(10,$s_val) }}</h4>
                                                         </div>
                                                            @forelse(\App\Models\Role::rolePluck() as $p_key => $p_val)
                                                            @php
                                                                $rold_id = \App\Models\Role::id($p_key);
                                                                $chk = \App\Models\ProcessAppFlow::where(['role_id'=>$rold_id,'process_id'=>$key,'status_id'=>$s_val])->count();
                                                            @endphp
                                                            <div class="col-md-3">
                                                                <div class="i-checks pull-left">
                                                                    <label>
                                                                        <input type="checkbox" value="{{$p_key}}" class="role_process_chk" name="process_flow[{{$key}}][{{$s_val}}][]" @if($chk) checked @endif > <i></i> {{$p_val}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    @empty
                                                    @endforelse
                                            </div>
                                        @endif
                                    
                                    <!-- <hr /> -->
                            	@empty

                            	@endforelse
                                    

                                  
                            </div>
                        </div>
                        <div class="col-md-12 form_btnbox">
                                    

                            <button type="submit" class="btn  btn-custon-save btn-primary">{{ __('Save') }}</button>
                          
                        </div>
                    </form>
                </div>
                <!-- end pro -->
               
            </div>
        @endif
    </div>
</div>
        <!--  -->
        
</x-admin-home-layout>

    