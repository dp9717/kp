<x-user-login-layout>
   <form method="POST" action="{{ route('user.chklogin') }}">
        @csrf
        
        <div class="login_check_box">
            <label for="login_chk" class="checkbox">
              <input type="radio" name="login_chk" class="checkbox__input" id="login_chk" />
              <span class="checkbox__inner"></span>
              Student Login
            </label>
            <label for="login_chk2" class="checkbox">
              <input type="radio" name="login_chk" checked class="checkbox__input" id="login_chk2" />
              <span class="checkbox__inner"></span>
              Official Login
            </label>
        </div>

        <!-- Email Address -->
        <div class="input-group">
            <!--<label>Username</label>-->
           <div class="inputbox">
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="input-group">
                <!--<label>Password</label>-->
               <div class="inputbox">
                    <x-text-input id="password" class="form-control"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" placeholder="Password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>
        <p class="terms_cnt">By continuing , you agree to SSRDP’s <a href="#">Privacy Policy</a>, <a href="#">Cookie Policy</a> & all other <a href="#">Terms & Conditions</a></p>
        <div class="input-group mb-0 captcha_group">
                <h3>Security Check</h3>
                <p>Enter the <strong>Letters</strong> below.</p>
                <div class="captcha_warp">
                  <span class="captcha-image refresh-button">{!! Captcha::img() !!}</span>
                </div>
                 <div class="captcha_text">
                  
                                {{ Form::text('captcha','',['class'=>'form-control','id'=>'captcha','required'=>true,'onkeyup'=>"chkCapcha()", 'placeholder'=>'Capcha']) }}
                </div>
                <span class="text-danger term">{{ $errors->first('captcha') }}</span>
          </div>

        <!-- Remember Me 
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>-->

        <div class="row">
            <div class="col-12 lr_footer">
                <button type="button" class="btn btn-primary btn-block logbtn btn_grey" disabled>Sign In</button>
            </div>
        </div>
        <!--<div class="Contact_admin">-->
        <!--    <h4>Not yet registered,<a href="{{route('user.register')}}">Sign up</a></h4>-->
        <!--</div>-->
    </form>

</x-user-login-layout>
<script type="text/javascript">
    function chkCapcha() {
    var val = $('#captcha').val();
      if (val && (val.length > 3)) {
          var url="{{ route('user.checkCapcha') }}";
            $.ajax({
              type:"POST",
              url:url,
              data:{captcha:val , _token: '{{csrf_token()}}',type:'loginChkCapcha'},
              beforeSend: function(){
              // $('#preloader').show();
              },
              success:function(response){

                if(response && response.status==1){
                    $('.lr_footer .logbtn').removeClass('btn_grey');
                    $('.lr_footer .logbtn').prop('type', 'submit');
                    $('.lr_footer .logbtn').prop('disabled', false);
                }else{
                    $('.lr_footer .logbtn').addClass('btn_grey');
                    $('.lr_footer .logbtn').prop('type', 'button');
                    $('.lr_footer .logbtn').prop('disabled', true);
                    $(".refresh-button").click();
                    $('#captcha').val(null);
                }
              }
            });
      }
}
    $(document).ready(function() {
        $('.refresh-button').click(function() {
            $.ajax({
                type: 'get',
                url: "{{ route('user.refreshCaptcha') }}",
                success:function(data) {
                    $('.captcha-image').html(data.captcha);
                }
            });
        });
    });
</script>
