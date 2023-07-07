<x-admin-home-layout>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="breadcome-list">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="breadcome-heading">
                        <h1>Edit Setting</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <ul class="breadcome-menu">
                            <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                            </li>
                            <li><span class="bread-blod">Setting</span>
                            </li>
                        </ul>
                    </div>
                </div>
               
                <!--  -->
            </div>
        </div>
        <!-- pro -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form_section bottomspace">
                <div class="row">
                    <div class="col-md-12"> <h1>Setting </h1></div> 
                    <form method="post" action="{{ route('admin.setting.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                {{ Form::text('title',$data->title ?? '',['class'=>'form-control','id'=>'title','placeholder'=>'Title'])}}
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row"> 
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="logo">Logo</label>
                                        {{ Form::file('logo',['class'=>'form-control']) }}
                                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                                    </div>
                                    @if($data->logo)
                                       <a href="{{ asset('public/'.$data->logo) }}" title="{{ $data->logo }}" target="_blank">
                                            {!! Html::decode(Helper::getDocType('public/', $data->logo)) !!}
                                        </a>
                                    @endif
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="logo">Mobile Logo</label>
                                        {{ Form::file('moblogo',['class'=>'form-control']) }}
                                        <span class="text-danger">{{ $errors->first('moblogo') }}</span>
                                        
                                    </div>
                                    @if($data->moblogo)
                                       <a href="{{ asset('public/'.$data->moblogo) }}" title="{{ $data->moblogo }}" target="_blank">
                                            {!! Html::decode(Helper::getDocType('public/', $data->moblogo)) !!}
                                        </a>
                                    @endif
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fevicon">Fevicon icon</label>
                                        {{ Form::file('fevicon',['class'=>'form-control']) }}
                                        <span class="text-danger">{{ $errors->first('fevicon') }}</span>
                                       
                                    </div>
                                    @if($data->fevicon)
                                       <a href="{{ asset('public/'.$data->fevicon) }}" title="{{ $data->fevicon }}" target="_blank">
                                            {!! Html::decode(Helper::getDocType('public/', $data->fevicon)) !!}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 form_btnbox profile_btn">
                            <button type="submit" class="btn btn-custon-save btn-primary">{{ __('Save') }}</button>
                        </div>                 
                    </form>
                </div>
            </div>
        </div>
        <!-- end pro -->
        </div>
    </div>
</div>
</x-admin-home-layout>
