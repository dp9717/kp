<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @php 
    $h = \App\Models\Setting::first();
    $logo = $h->logo ?? 'img/logo/logo.png';
    $moblogo = $h->moblogo ?? 'img/logo/logosn.png';
    $fevicon = $h->fevicon ?? 'img/favicon.ico';
 @endphp
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $h->title ?? config('app.name')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
        ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('public/'.$fevicon) }}">
    <!-- Google Fonts
        ============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
        ============================================ -->
    {{ Html::style('public/css/bootstrap.min.css') }}
    <!-- Bootstrap CSS
        ============================================ -->
    {{ Html::style("public/css/font-awesome.min.css") }}

    {{ Html::style("public/css/main.css") }}
   
    {{ Html::style("public/style.css") }}
    {{ Html::style("public/login.css") }}
    <!-- responsive CSS
    ============================================ -->
    {{ Html::style('public/css/responsive.css') }}
    <!-- modernizr JS
    ============================================ -->
    {{ Html::script('public/js/vendor/modernizr-2.8.3.min.js') }}
</head>
    <body>
        <div class="login-page">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="top_action_btn">
                       
                    </div>
                    <div class="login-box">
                    @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>Success ! </strong> {{Session::get('success')}}
                    </div>
                    @elseif(Session::has('failed'))
                    <div class="alert alert-danger" role="alert">
                        <strong>Failed ! </strong> {{Session::get('failed')}}
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-body login-card-body">
                            <div class="login_logo"> <img src="{{url('public/'.$logo)}}"> </div>
                            <div class="title_text"> <h2>SRI SRI RURAL DEVELOPEMENT PROGRAMME TRUST (SSRDP)’s</h2></div>
                            <div class="sub_title">  <h4>KAUSHAL PATH 1.0</h4> </div>
                             <h6> Centralised Project Management System (CPMS)</h6>
                           <div class="formsection"> 

                            <!-- slot -->
                            @if(isset($data->token_key) && $data->token_key)
                                <form method="POST" action="{{ route('user.tokenStore',$data->token_key) }}" class="registerUser" enctype="multipart/form-data">
                                    @csrf
                                    <!-- user -->

                                    <!-- Email Address -->

                                   <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="new_password">Enter New Password</label>
                                            {{ Form::password('new_password',['class'=>'form-control','id'=>'new_password','placeholder'=>'New Password'])}}
                                            <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password</label>
                                            {{ Form::password('confirm_password',['class'=>'form-control','id'=>'confirm_password','placeholder'=>'Confirm Password'])}}
                                            <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                        </div>
                                    </div>
                                   
                                    <!-- <p class="terms_cnt">By continuing , you agree to SSRDP’s <a href="#">Privacy Policy</a>, <a href="#">Cookie Policy</a> & all other <a href="#">Terms & Conditions</a></p> -->



                                    
                                        <div class="col-md-12 lr_footer">
                                            <button type="submit" class="btn btn-primary btn-block">Save Password</button>
                                        </div>
                                        <!--<div class="col-md-12 Contact_admin">-->
                                        <!--    <h4>Already registered,<a href="{{route('user.login')}}">Log in</a></h4>-->
                                        <!--</div>-->
                                </form>
                            @else
                                <h2 class="text-danger">Token expired ! Please contact to admin</h2> 
                            @endif
                            <!--end slot -->
                           </div>
                        </div>
                    </div>  
                  </div>             
               </div>
           </div>
         </div>
      </div>
    </body>

     <!-- jquery
    ============================================ -->

    {{ Html::script('public/js/vendor/jquery-1.12.4.min.js') }}
    <!-- bootstrap JS
    ============================================ -->
    {{ Html::script('public/js/bootstrap.min.js') }}

</html>

    
       
