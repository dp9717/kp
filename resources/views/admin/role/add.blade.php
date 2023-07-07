<x-admin-home-layout>
<div class="main-content">
    <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                             <h1>Add Role</h1>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                </li>
                                <li><a href="{{ route('admin.roles') }}">Roles</a> <span class="bread-slash">/</span>
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
                <form method="post" action="{{ route('admin.saveRole') }}" class="mt-6 space-y-6">
                    @csrf
                    <div class="form_section">
                        <div class="row">
                            <div class="col-md-12"> <h1>Role Details</h1></div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Name</label>
                                    {{ Form::text('name',$data->name ?? '',['class'=>'form-control','id'=>'username','placeholder'=>'Username'])}}
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    {{ Form::select('category',$category,[$data->category_id ?? ''],['class'=>'form-control','id'=>'category','placeholder'=>'Choose Category'])}}
                                    <span class="text-danger">{{ $errors->first('category') }}</span>
                                </div>
                            </div>

                        </div>
                    </div>

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
