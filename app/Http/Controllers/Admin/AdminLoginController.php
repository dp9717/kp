<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Captcha;
use Validator;
class AdminLoginController extends Controller
{
    function __construct($foo = null)
    {
        $this->foo = $foo;
    }

    public function login($value='')
    {
        if (isset(auth()->user()->is_admin) && auth()->user()->is_admin==0) {
            return to_route('admin.home');
        }
        return view('admin.auth.login');
    }

    public function chkLogin(Request $request)
    {
        $input = $request->all();
     
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
     
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            //if (auth()->user()->is_admin == 0) {
                return redirect()->route('admin.home');
            // }else {
            //     echo 'user dashboard under maintenance';
            // }
        }else{
            return redirect()->route('admin.login')
                ->with('failed','Email-Address And Password Are Wrong.');
        }

    }

    public function checkCapcha(Request $request)
    { 
        $validator =Validator::make($request->all(), ['captcha' => 'required|captcha', // this will validate captcha
        ],['captcha.captcha'=>'Captcha does not match..']);

        if ($validator->passes()) {
            return response()->json(['status'=>1,'msg'=>'Added new records.']);
        }


        return response()->json(['status'=>0,'msg'=>$validator->errors()->first('captcha')]);
    }

    public function refreshCaptcha(Request $request)
    {
        return response()->json([
            'captcha' => Captcha::img()
        ]);
    }
    
}
