<x-admin-home-layout>
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                               <!--  <a class="btn btn-custon-four btn-default text-success back" href="{{ route('admin.users') }}" title="Back"><i class="fa fa-arrow-circle-left"></i></a> -->
                                <h1>Add Module</h1>
                            </div>  
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                </li>
                                <li><a href="{{ route('admin.modules') }}">Modules</a> <span class="bread-slash">/</span>
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
                <form method="post" action="{{ route('admin.saveModule') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf

                    <div class="form_section">
                        <div class="row">
                            <div class="col-md-12"> <h1>Module Information</h1></div>   

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    {{ Form::text('name','',['class'=>'form-control','id'=>'name','placeholder'=>'Name'])}}
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="duration">Duration</label>
                                    {{ Form::text('duration', '',['class'=>'form-control','id'=>'duration','placeholder'=>'Duration'])}}
                                    <span class="text-danger">{{ $errors->first('duration') }}</span>
                                </div>
                            </div>
                    </div>

                    

                    <div class="form_section">
                        <div class="row">
                            <div class="col-md-12"> <h1>Additional information</h1></div> 

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="description">Additional information</label>
                                    {{ Form::textarea('description','',['class'=>'form-control','id'=>'description','placeholder'=>'Additional information','rows'=>2])}}
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

            
                    <div class="col-md-12 form_btnbox">
                        <button type="submit" class="btn btn-custon-save  btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
            <!-- end pro -->
        </div>
    </div>
</div>
</x-admin-home-layout>
