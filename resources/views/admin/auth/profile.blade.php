<x-admin-home-layout>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                               <h1>Edit Profile</h1>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                </li>
                                <li><span class="bread-blod">Profile</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                   
                    <!--  --> 
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                 <div class="form_section">
                    <div class="row">
                    <div class="col-md-12"> <h1>Profile Detail</h1></div> 

                    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
                        @csrf

                            <div id="pwd-container3">
                                <div class="form-group col-md-6">
                                    <label for="username">Name</label>
                                    {{ Form::text('name',$user->name ?? '',['class'=>'form-control','id'=>'username','placeholder'=>'Username'])}}
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Email">Email</label>
                                    {{ Form::email('email',$user->email ?? '',['class'=>'form-control','id'=>'Email','placeholder'=>'Email'])}}
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>

                                <div class="col-md-12 form_btnbox profile_btn">
                                  <button type="submit" class="btn btn-custon-save btn-primary">{{ __('Save') }}</button>
                              </div>
                        </div>
                    </form>

                    </div>
                </div>

                <div class="form_section bottomspace">
                    <div class="row">
                        <div class="col-md-12"> <h1>Change Password</h1></div> 
                        <form method="post" action="{{ route('admin.password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            <div class="form-group col-md-4">
                                <label for="password">Current Password</label>
                                {{ Form::password('current_password',['class'=>'form-control','id'=>'password','placeholder'=>'Current Password'])}}
                                <span class="text-danger">{{ $errors->first('current_password') }}</span>
                            </div>
                            <div class="form-group col-md-4">
                                    <label for="new_password">New Password</label>
                                    {{ Form::password('new_password',['class'=>'form-control','id'=>'new_password','placeholder'=>'New Password'])}}
                                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                            </div>
                            <div class="form-group col-md-4">
                                    <label for="confirm_password">Confirm Password</label>
                                    {{ Form::password('confirm_password',['class'=>'form-control','id'=>'confirm_password','placeholder'=>'Confirm Password'])}}
                                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                            </div>
                            <div class="col-md-12 form_btnbox profile_btn">
                                    <button type="submit" class="btn btn-custon-save btn-primary">{{ __('Change') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</div>
</x-admin-home-layout>
