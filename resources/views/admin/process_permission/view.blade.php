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
                                   <h1>{{ $role->name }} Permission</h1>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><span class="bread-blod"><a href="{{ route('admin.roles') }}">Role</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><span class="bread-blod">Process Permission</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                       
                        <!--  -->
                    </div>
                </div>
                <!-- pro -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form method="post" action="{{ route('admin.process_permission',$role->slug) }}" class="mt-6 space-y-6">
                        @csrf
                    <div class="form_section">
                        <div class="col-md-12">
                        	@forelse($process as $key => $val)
                                <div class="row">
                            		<div class="col-md-3">
                                        <div class="form-group">
                                            <h4 for="username">{{ Helper::process($val->process_id) }}</h4>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            @forelse(Helper::permission() as $p_key => $p_val)
                                            @php
                                                $key = $val->process_id;
                                                $data = \App\Models\ProcessPermission::where(['process_id'=>$key,'permission_id'=>$p_key,'role_id'=>$val->role_id])->count();
                                            @endphp
                                            <div class="col-md-2">
                                                <div class="i-checks pull-left">
                                                    <label>
                                                        <input type="checkbox" value="{{$p_key}}" class="role_process_chk" name="process_permission[{{$key}}][]" @if($data) checked @endif> <i></i> {{$p_val}}
                                                    </label>
                                                </div>
                                            </div>
                                            @empty

                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                <hr />
                        	@empty

                        	@endforelse
                                

                             
                        </div>
                    </div>
                       <div class="col-md-12 form_btnbox">
                                   <button type="submit" class="btn btn-custon-save btn-primary">{{ __('Save') }}</button>
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

    